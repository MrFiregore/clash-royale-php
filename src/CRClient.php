<?php

namespace CR;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use CR\Exceptions\CRSDKException;
use CR\HttpClients\GuzzleHttpClient;
use CR\HttpClients\HttpClientInterface;

/**
 * Class CRClient.
 */
class CRClient
{
    /**
     * @const string CR Bot API URL.
     */
    const BASE_URL = 'http://api.cr-api.com/';

    /**
     * @var HttpClientInterface|null HTTP Client
     */
    protected $httpClientHandler;

    /**
     * Instantiates a new CRClient object.
     *
     * @param HttpClientInterface|null $httpClientHandler
     */
    public function __construct(HttpClientInterface $httpClientHandler = null)
    {
        $this->httpClientHandler = $httpClientHandler ?: new GuzzleHttpClient();
    }

    /**
     * Sets the HTTP client handler.
     *
     * @param HttpClientInterface $httpClientHandler
     */
    public function setHttpClientHandler(HttpClientInterface $httpClientHandler)
    {
        $this->httpClientHandler = $httpClientHandler;
    }

    /**
     * Returns the HTTP client handler.
     *
     * @return HttpClientInterface
     */
    public function getHttpClientHandler()
    {
        return $this->httpClientHandler;
    }

    /**
     * Returns the base Bot URL.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return static::BASE_URL;
    }

    /**
     * Prepares the API request for sending to the client handler.
     *
     * @param CRRequest $request
     *
     * @return array
     */
    public function prepareRequest(CRRequest $request)
    {
        $url = $this->getBaseUrl().$request->getEndpoint()."/".implode(",",$request->getParams());

        return [
            $url,
            $request->getMethod(),
            $request->getHeaders(),
            $request->isAsyncRequest(),
        ];
    }

    /**
     * Send an API request and process the result.
     *
     * @param CRRequest $request
     *
     * @throws CRSDKException
     *
     * @return CRResponse
     */
    public function sendRequest(CRRequest $request)
    {
        list($url, $method, $headers, $isAsyncRequest) = $this->prepareRequest($request);
        $timeOut = $request->getTimeOut();
        $connectTimeOut = $request->getConnectTimeOut();
        $options = [];
        $rawResponse = $this->httpClientHandler->send($url, $method, $headers, $options, $timeOut, $isAsyncRequest, $connectTimeOut);

        $returnResponse = $this->getResponse($request, $rawResponse);

        if ($returnResponse->isError()) {
            throw $returnResponse->getThrownException();
        }

        return $returnResponse;
    }

    /**
     * Creates response object.
     *
     * @param CRRequest                    $request
     * @param ResponseInterface|PromiseInterface $response
     *
     * @return CRResponse
     */
    protected function getResponse(CRRequest $request, $response)
    {
        return new CRResponse($request, $response);
    }
}
