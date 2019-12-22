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
    
    namespace CR\Exceptions;
    
    use CR\CRResponse;

    /**
     * CRResponseException.
     */
    class CRResponseException extends CRSDKException
    {
        /**
         * @var CRResponse the response that threw the exception
         */
        protected $response;
        
        /**
         * @var array decoded response
         */
        protected $responseData;
        
        /**
         * Creates a CRResponseException.
         *
         * @method __construct
         *
         * @param CRResponse          $response          the response that threw the exception
         * @param null|CRSDKException $previousException the more detailed exception
         */
        public function __construct (CRResponse $response, CRSDKException $previousException = null)
        {
            $this->response     = $response;
            $this->responseData = $response->getDecodedBody();
            
            $errorMessage = $this->get('message', $response->getHttpStatusMessage());
            $errorCode    = $this->get('error', $response->getHttpStatusCode());
            parent::__construct($errorMessage, $errorCode, $previousException);
        }
        
        /**
         * A factory for creating the appropriate exception based on the response from CR.
         *
         * @param CRResponse $response the response that threw the exception
         *
         * @return CRResponseException
         */
        public static function create (CRResponse $response)
        {
            $data = $response->getDecodedBody();
            
            $code    = null;
            $message = null;
            if (isset($data['error']) && false !== $data['error']) {
                $code    = $response->getHttpStatusCode();
                $message = isset($data['message']) ? $data['message'] : $response->getHttpStatusMessage();
            }
            else {
                $code    = $response->getHttpStatusCode();
                $message = isset($data['message']) ? $data['message'] : $response->getHttpStatusMessage();
            }
            
            // Others
            return new static($response, new CROtherException($message, $code));
        }
        
        /**
         * Returns the HTTP status code.
         *
         * @return int
         */
        public function getHttpStatusCode ()
        {
            return $this->response->getHttpStatusCode();
        }
        
        /**
         * Returns the error type.
         *
         * @return string
         */
        public function getErrorType ()
        {
            return $this->get('type', '');
        }
        
        /**
         * Returns the raw response used to create the exception.
         *
         * @return string
         */
        public function getRawResponse ()
        {
            return $this->response->getBody();
        }
        
        /**
         * Returns the decoded response used to create the exception.
         *
         * @return array
         */
        public function getResponseData ()
        {
            return $this->responseData;
        }
        
        /**
         * Returns the response entity used to create the exception.
         *
         * @return CRResponse
         */
        public function getResponse ()
        {
            return $this->response;
        }
        
        /**
         * Checks isset and returns that or a default value.
         *
         * @param string $key
         * @param mixed  $default
         *
         * @return mixed
         */
        private function get ($key, $default = null)
        {
            if (isset($this->responseData[$key])) {
                return $this->responseData[$key];
            }
            
            return $default;
        }
    }
