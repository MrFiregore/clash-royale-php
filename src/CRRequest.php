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
 ~ If not, see <http://www.gnu.org/licenses/> 2018.05.31                                                                                                                                                                                                    ~
 ~                                                                                                                                                                                                                                                          ~
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
 namespace CR;
 use CR\Exceptions\CRSDKException;

/**
 * Class CRRequest.
 *
 * Builds CR Bot API Request Entity.
 */
class CRRequest
{
  /**
  * @var string|null The API auth token to use for this request.
  */
  protected $auth_token;

    /**
     * @var string The HTTP method for this request.
     */
    protected $method;

    /**
     * @var string The API endpoint for this request.
     */
    protected $endpoint;

    /**
     * @var array The headers to send with this request.
     */
    protected $headers = [];

    /**
     * @var array The parameters to send with this request.
     */
    protected $params = [];
    /**
     * @var array The query to send with this request.
     */
    protected $querys = [];

    /**
     * @var array The files to send with this request.
     */
    protected $files = [];

    /**
     * Indicates if the request to CR will be asynchronous (non-blocking).
     *
     * @var bool
     */
    protected $isAsyncRequest = false;

    /**
     * Timeout of the request in seconds.
     *
     * @var int
     */
    protected $timeOut = 120;

    /**
     * Connection timeout of the request in seconds.
     *
     * @var int
     */
    protected $connectTimeOut = 10;

    /**
     * Creates a new Request entity.
     * @method __construct
     * @param  string|null      $auth_token     [description]
     * @param  string|null      $endpoint       [description]
     * @param  array            $params         [description]
     * @param  array            $querys          [description]
     * @param  bool             $isAsyncRequest [description]
     * @param  int              $timeOut        [description]
     * @param  int              $connectTimeOut [description]
     */

    public function __construct(
      $auth_token,
      $endpoint = null,
      array $params = [],
      array $querys = [],
      $isAsyncRequest = false,
      $timeOut = 120,
      $connectTimeOut = 10
    ) {
      $this->setAuthToken($auth_token);
      $this->setMethod("GET");
      $this->setEndpoint($endpoint);
      $this->setParams($params);
      $this->setQuerys($querys);
      $this->setAsyncRequest($isAsyncRequest);
      $this->setTimeOut($timeOut);
      $this->setConnectTimeOut($connectTimeOut);
      $this->setHeaders(["Authorization"=>"Bearer ".$this->getAuthToken(),"auth"=>$this->getAuthToken()]);
    }
    /**
    * Set the API auth token for this request.
    *
    * @param string $auth_token
    *
    * @return CRRequest
    */
    public function setAuthToken($auth_token)
    {
      $this->auth_token = $auth_token;

      return $this;
    }


    /**
     * @return string|null
     */
    public function getAuthToken()
    {
      return $this->auth_token;
    }


    /**
     * Set the HTTP method for this request.
     *
     * @param string $method
     *
     * @return CRRequest
     */
    public function setMethod($method)
    {
        $this->method = strtoupper($method);

        return $this;
    }

    /**
     * Return the HTTP method for this request.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Validate that the HTTP method is set.
     *
     * @throws CRSDKException
     */
    public function validateMethod()
    {
        if (!$this->method) {
            throw new CRSDKException('HTTP method not specified.');
        }

        if (!in_array($this->method, ['GET', 'POST'])) {
            throw new CRSDKException('Invalid HTTP method specified.');
        }
    }

    /**
     * Set the endpoint for this request.
     *
     * @param string $endpoint
     *
     * @return CRRequest
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Return the API Endpoint for this request.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Set the params for this request.
     *
     * @param array $params
     *
     * @return CRRequest
     */
    public function setParams(array $params = [])
    {
      $this->params = array_merge($this->params, $params);

      return $this;
    }

    /**
     * Return the params for this request.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }
    /**
     * Set the querys for this request.
     *
     * @param array $query
     *
     * @return CRRequest
     */
    public function setQuerys(array $query = [])
    {
      $this->query = array_merge($this->querys, $query);

      return $this;
    }

    /**
     * Return the querys for this request.
     *
     * @return array
     */
    public function getQuerys()
    {
        return $this->query;
    }

    /**
     * Set the headers for this request.
     *
     * @param array $headers
     *
     * @return CRRequest
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    /**
     * Return the headers for this request.
     *
     * @return array
     */
    public function getHeaders()
    {
        $headers = $this->getDefaultHeaders();

        return array_merge($this->headers, $headers);
    }

    /**
     * Make this request asynchronous (non-blocking).
     *
     * @param bool $isAsyncRequest
     *
     * @return CRRequest
     */
    public function setAsyncRequest($isAsyncRequest)
    {
        $this->isAsyncRequest = $isAsyncRequest;

        return $this;
    }

    /**
     * Check if this is an asynchronous request (non-blocking).
     *
     * @return bool
     */
    public function isAsyncRequest()
    {
        return $this->isAsyncRequest;
    }

    /**
     * Only return params on POST requests.
     *
     * @return array
     */
    public function getPostParams()
    {
        if ($this->getMethod() === 'POST') {
            return $this->getParams();
        }

        return [];
    }

    /**
     * The default headers used with every request.
     *
     * @return array
     */
    public function getDefaultHeaders()
    {
        return [
          'User-Agent' => 'CR PHP SDK Firegore',
        ];
    }

    /**
     * @return int
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * @param int $timeOut
     *
     * @return $this
     */
    public function setTimeOut($timeOut)
    {
        $this->timeOut = $timeOut;

        return $this;
    }

    /**
     * @return int
     */
    public function getConnectTimeOut()
    {
        return $this->connectTimeOut;
    }

    /**
     * @param int $connectTimeOut
     *
     * @return $this
     */
    public function setConnectTimeOut($connectTimeOut)
    {
        $this->connectTimeOut = $connectTimeOut;

        return $this;
    }
}
