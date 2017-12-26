<?php

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
    protected $timeOut = 30;

    /**
     * Connection timeout of the request in seconds.
     *
     * @var int
     */
    protected $connectTimeOut = 10;

    /**
     * Creates a new Request entity.
     *
     * @param string|null $auth_token
     * @param string|null $method
     * @param string|null $endpoint
     * @param array|null  $params
     * @param bool        $isAsyncRequest
     * @param int         $timeOut
     * @param int         $connectTimeOut
     */
    public function __construct(
      $auth_token,
      $endpoint = null,
      array $params = [],
      $isAsyncRequest = false,
      $timeOut = 60,
      $connectTimeOut = 10
    ) {
      $this->setAuthToken($auth_token);
      $this->setMethod("GET");
      $this->setEndpoint($endpoint);
      $this->setParams($params);
      $this->setAsyncRequest($isAsyncRequest);
      $this->setTimeOut($timeOut);
      $this->setConnectTimeOut($connectTimeOut);
      $this->setHeaders(["auth"=>$this->getAuthToken()]);

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
     * @param string
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
     * @param $isAsyncRequest
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
