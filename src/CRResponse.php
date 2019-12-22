<?php
    
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
     ~                                                                                                                                                                                                                                                          ~
     ~ Copyright (c) 2018 by firegore (https://firegore.es) (git:firegore2)                                                                                                                                                                                     ~
     ~ This file is part of clash-royale-php.                                                                                                                                                                                                                   ~
     ~                                                                                                                                                                                                                                                          ~
     ~ clash-royale-php is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
     ~ clash-royale-php is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                                                                  ~
     ~ See the GNU Affero General Public License for more details.                                                                                                                                                                                              ~
     ~ You should have received a copy of the GNU General Public License along with clash-royale-php.                                                                                                                                                           ~
     ~ If not, see <http://www.gnu.org/licenses/> 2018.06.13                                                                                                                                                                                                    ~
     ~                                                                                                                                                                                                                                                          ~
     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    
    namespace CR;
    
    use CR\Exceptions\CRResponseException;
    use CR\Exceptions\CRSDKException;
    use GuzzleHttp;
    use GuzzleHttp\Promise\PromiseInterface;
    use GuzzleHttp\Psr7\Response;
    use Psr\Http\Message\ResponseInterface;

    /**
     * Class CRResponse.
     *
     * Handles the response from CR API.
     */
    class CRResponse
    {
        /**
         * @var null|int the HTTP status code response from API
         */
        protected $httpStatusCode;
        
        /**
         * @var array the headers returned from API request
         */
        protected $headers;
        
        /**
         * @var string the raw body of the response from API request
         */
        protected $body;
        
        /**
         * @var array the stats of the response from API request
         */
        protected $stats = [];
        
        /**
         * @var array the decoded body of the API response
         */
        protected $decodedBody = [];
        
        /**
         * @var string API Endpoint used to make the request
         */
        protected $endPoint;
        
        /**
         * @var CRRequest the original request that returned this response
         */
        protected $request;
        
        /**
         * @var CRSDKException the exception thrown by this request
         */
        protected $thrownException;
        /** @var array Map of standard HTTP status code/reason phrases */
        private static $phrases = [
            400 => 'Bad Request -- Your request sucks.',
            401 => 'Unauthorized -- No authentication was provided, or key invalid.',
            404 => 'Not Found -- The specified player / clan cannot be found. Could be invalid tags',
            500 => 'Internal Server Error -- We had a problem with our server. Try again later.',
            503 => "Service Unavailable -- We're temporarily offline for maintenance. Please try again later.",
            521 => 'Service Unavailable -- Web server is down',
        ];
        
        /**
         * Gets the relevant data from the Http client.
         *
         * @param PromiseInterface|ResponseInterface $response
         * @param array                              $stats
         */
        public function __construct (CRRequest $request, $response, $stats = [])
        {
            if ($response instanceof ResponseInterface) {
                $this->httpStatusCode = $response->getStatusCode();
                $this->body           = $response->getBody();
                $this->headers        = $response->getHeaders();
                $this->decodeBody();
            }
            elseif ($response instanceof PromiseInterface) {
                $this->httpStatusCode = null;
            }
            else {
                throw new \InvalidArgumentException(
                    'Second constructor argument "response" must be instance of ResponseInterface or PromiseInterface'
                );
            }
            $this->stats    = $stats;
            $this->request  = $request;
            $this->endPoint = (string)$request->getEndpoint();
        }
        
        /**
         * Converts raw API response to proper decoded response.
         */
        public function decodeBody ()
        {
            $this->decodedBody = json_decode($this->body, true);
            
            if (null === $this->decodedBody) {
                $this->decodedBody = [];
                $this->getBody()->rewind();
                $body = $this->getBody()->getContents();
                $this->getBody()->rewind();
                
                if (CRUtils::isHTMLPage($body)) {
                    $this->decodedBody[] = $body;
                }
                else {
                    parse_str($body, $this->decodedBody);
                }
            }
            
            if (!is_array($this->decodedBody)) {
                $this->decodedBody = [];
            }
            
            if ($this->isError()) {
                $this->makeException();
            }
        }
        
        /**
         * Return the raw body response.
         *
         * @return GuzzleHttp\Psr7\Stream
         */
        public function getBody ()
        {
            return $this->body;
        }
        
        /**
         * Checks if response is an error.
         *
         * @return bool
         */
        public function isError ()
        {
            return isset($this->decodedBody['error']) && (true === $this->decodedBody['error']) || (!is_null($this->getHttpStatusCode()) && 200 !== $this->getHttpStatusCode());
        }
        
        /**
         * Gets the HTTP status code.
         * Returns NULL if the request was asynchronous since we are not waiting for the response.
         *
         * @return null|int
         */
        public function getHttpStatusCode ()
        {
            return $this->httpStatusCode;
        }
        
        /**
         * Instantiates an exception to be thrown later.
         */
        public function makeException ()
        {
            $this->thrownException = CRResponseException::create($this);
        }
        
        /**
         * Return the original request that returned this response.
         *
         * @return CRRequest
         */
        public function getRequest ()
        {
            return $this->request;
        }
        
        /**
         * Return the stats information about this request.
         *
         * @method getStats
         *
         * @return array The stats information about this request
         */
        public function getStats ()
        {
            return $this->stats;
        }
        
        /**
         * [getHttpStatusMessage description].
         *
         * @method getHttpStatusMessage
         *
         * @return string [description]
         */
        public function getHttpStatusMessage ()
        {
            $code = $this->getHttpStatusCode();
            
            return (isset(self::$phrases[$code])) ? self::$phrases[$code] : (new Response($code))->getReasonPhrase();
        }
        
        /**
         * Gets the Request Endpoint used to get the response.
         *
         * @return string
         */
        public function getEndpoint ()
        {
            return $this->endPoint;
        }
        
        /**
         * Return the API auth token that was used for this request.
         *
         * @return null|string
         */
        public function getAuthToken ()
        {
            return $this->request->getAuthToken();
        }
        
        /**
         * Return the HTTP headers for this response.
         *
         * @return array
         */
        public function getHeaders ()
        {
            return $this->headers;
        }
        
        /**
         * Return the decoded body response.
         *
         * @return array
         */
        public function getDecodedBody ()
        {
            return $this->decodedBody;
        }
        
        /**
         * Helper function to return the payload of a successful response.
         *
         * @return mixed
         */
        public function getResult ()
        {
            return $this->decodedBody['result'];
        }
        
        /**
         * Throws the exception.
         *
         * @throws CRSDKException
         */
        public function throwException ()
        {
            throw $this->thrownException;
        }
        
        /**
         * Returns the exception that was thrown for this request.
         *
         * @return CRSDKException
         */
        public function getThrownException ()
        {
            return $this->thrownException;
        }
    }
