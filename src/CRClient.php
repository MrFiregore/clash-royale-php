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
    <<<<<<< HEAD
     ~ If not, see <http://www.gnu.org/licenses/> 2018.06.13                                                                                                                                                                                                    ~
    =======
     ~ If not, see <http://www.gnu.org/licenses/> 2018.05.31                                                                                                                                                                                                    ~
    >>>>>>> b2a5d15d43f75f0cb178f814fadb92d12c10fbdb
     ~                                                                                                                                                                                                                                                          ~
     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    
    namespace CR;
    
    use CR\Exceptions\CRSDKException;
    use CR\HttpClients\GuzzleHttpClient;
    use CR\HttpClients\HttpClientInterface;
    use CR\Traits\RulesTrait;
    use GuzzleHttp\Client;
    use GuzzleHttp\Promise\PromiseInterface;
    use GuzzleHttp\Psr7\Response;
    use GuzzleHttp\RequestOptions;
    use GuzzleHttp\TransferStats;
    use Psr\Http\Message\ResponseInterface;

    /**
     * Class CRClient.
     */
    class CRClient
    {
        use RulesTrait;
        
        /**
         * @var string BASE_URL CR Bot API URL
         */
        const BASE_URL = 'https://api-v3.royaleapi.com';
        
        /**
         * @var GuzzleHttpClient|HttpClientInterface HTTP Client
         */
        protected $httpClientHandler;
        
        /**
         * Instantiates a new CRClient object.
         */
        public function __construct (HttpClientInterface $httpClientHandler = null)
        {
            if (!$httpClientHandler) {
                $client            = new Client(
                    [
                        'base_uri' => $this->getBaseUrl(),
                    ]
                );
                $httpClientHandler = new GuzzleHttpClient($client);
            }
            $this->httpClientHandler = $httpClientHandler;
        }
        
        /**
         * Sets the HTTP client handler.
         */
        public function setHttpClientHandler (HttpClientInterface $httpClientHandler)
        {
            $this->httpClientHandler = $httpClientHandler;
        }
        
        /**
         * Returns the HTTP client handler.
         *
         * @return HttpClientInterface
         */
        public function getHttpClientHandler ()
        {
            return $this->httpClientHandler;
        }
        
        /**
         * Returns the base Bot URL.
         *
         * @return string
         */
        public function getBaseUrl ()
        {
            return static::BASE_URL;
        }
        
        /**
         * Return the API url.
         *
         * @method getUrl
         *
         * @return string the API url
         */
        public function getUrl (CRRequest $request)
        {
            $url = $request->getEndpoint();
            
            if (false !== preg_match('/:(tag|cc|cc\\?)|{(tag|tags|name)}/i', $url)) {
                $params = ((empty($request->getParams())) ? '' : implode(',', $request->getParams()));
                $url    = preg_replace('/:(tag|cc|cc\?)|{(tag|tags|name)}/m', $params, $url);
            }
            
            return $url;
        }
        
        /**
         * Prepares the API request for sending to the client handler.
         *
         * @return array
         */
        public function prepareRequest (CRRequest $request)
        {
            return [
                $this->getUrl($request),
                $request->getMethod(),
                $request->getHeaders(),
                $request->isAsyncRequest(),
            ];
        }
        
        /**
         * Check the server status.
         *
         * @method ping
         *
         * @return bool Return true if is up, otherwise returns false
         */
        public function ping ()
        {
            return $this->httpClientHandler->ping(self::BASE_URL);
        }
        
        /**
         * Send an API request and process the result.
         *
         * @return CRResponse
         * @throws CRSDKException
         *
         */
        public function sendRequest (CRRequest $request)
        {
            list($url, $method, $headers, $isAsyncRequest) = $this->prepareRequest($request);
            $timeOut                                                                          = $request->getTimeOut();
            $connectTimeOut                                                                   = $request->getConnectTimeOut();
            $con_stats                                                                        = [];
            $options                                                                          = [
                RequestOptions::ON_STATS => function (TransferStats $stats) use (&$con_stats) {
                    if ($stats->hasResponse()) {
                        $this->setLastRequest();
                        $con_stats = $stats->getHandlerStats();
                    }
                },
                RequestOptions::HEADERS  => $request->getHeaders(),
            ];
            $options['GET' === $method ? RequestOptions::QUERY : RequestOptions::FORM_PARAMS] = $request->getQuerys();
            $this->waitRequest();
            $rawResponse    = $this->httpClientHandler->send($url, $method, $options, $timeOut, $isAsyncRequest, $connectTimeOut);
            $returnResponse = $this->getResponse($request, $rawResponse, $con_stats);
            
            if ($returnResponse->isError()) {
                throw $returnResponse->getThrownException();
            }
            $this->sendMetrics($request, $rawResponse);
            
            return $returnResponse;
        }
        
        /**
         * [sendMetrics description].
         *
         * @param CRRequest $request  [description]
         * @param Response  $response [description]
         *
         * @return [type] [description]
         */
        public function sendMetrics (CRRequest $request, Response $response)
        {
            if ($response->getBody()->eof()) {
                $response->getBody()->rewind();
            }
            
            $respb   = $response->getBody()->getContents();
            $options = [
                RequestOptions::HTTP_ERRORS => false,
            ];
            $data    = json_encode(
                [
                    'endpoint' => $request->getEndpoint(),
                    'params'   => $request->getParams(),
                    'token'    => $request->getAuthToken(),
                    'response' => $respb,
                ]
            );
            
            if (extension_loaded('zlib')) {
                $data                                                 = gzcompress($data, 9);
                $options[RequestOptions::HEADERS]['Content-Encoding'] = 'gzip';
                $options[RequestOptions::FORM_PARAMS]                 = ['gzip' => $data];
            }
            else {
                $options[RequestOptions::FORM_PARAMS] = ['json' => $data];
            }
            $this->httpClientHandler->send('https://cr.firegore.es/metrics.php', 'POST', $options, 5, true, 5);
        }
        
        /**
         * Creates response object.
         *
         * @param PromiseInterface|ResponseInterface $response
         * @param array                              $stats
         *
         * @return CRResponse
         */
        protected function getResponse (CRRequest $request, $response, $stats)
        {
            return new CRResponse($request, $response, $stats);
        }
    }
