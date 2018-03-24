<?php
/**************************************************************************************************************************************************************************************************************************************************************
 *                                                                                                                                                                                                                                                            *
 * Copyright (c) 2018 by Firegore (https://firegore.es) (git:firegore2).                                                                                                                                                                                      *
 * This file is part of clash-royale-php.                                                                                                                                                                                                                     *
 *                                                                                                                                                                                                                                                            *
 * clash-royale-php is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. *
 * clash-royale-php is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                                                                    *
 * See the GNU Affero General Public License for more details.                                                                                                                                                                                                *
 * You should have received a copy of the GNU General Public License along with clash-royale-php.                                                                                                                                                             *
 * If not, see <http://www.gnu.org/licenses/>.                                                                                                                                                                                                                *
 *                                                                                                                                                                                                                                                            *
 **************************************************************************************************************************************************************************************************************************************************************/


namespace CR;

use GuzzleHttp\TransferStats;

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
    const BASE_URL = 'http://api.royaleapi.com';

    /**
     * @var HttpClientInterface|GuzzleHttpClient HTTP Client
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
     * Return the API url
     * @method getUrl
     * @param  CRRequest $request
     * @return string             the API url
     */

    public function getUrl(CRRequest $request)
    {
      $url = $this->getBaseUrl().$request->getEndpoint();

      if (strpos($url,":tag") !== false) {
        $params = ( (empty($request->getParams())) ? "" : implode(",",$request->getParams()));
        $url = str_replace(":tag",$params,$url);
      }

      if (!empty($request->getQuerys())) {
        $url .= "?";
        foreach ($request->getQuerys() as $key => $query) {
          $url .= $key."=".( is_array($query) ? implode(",",$query) : $query)."&";
        }
        $url = substr($url,0,-1);
      }

      return $url;
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
        return [
            $this->getUrl($request),
            $request->getMethod(),
            $request->getHeaders(),
            $request->isAsyncRequest(),
        ];
    }


    /**
    * Check the server status
    * @method ping
    * @return bool Return true if is up, otherwise returns false
    */
    public function ping()
    {
      return $this->httpClientHandler->ping(self::BASE_URL);
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
        list($url,$method, $headers, $isAsyncRequest) = $this->prepareRequest($request);
        $timeOut = $request->getTimeOut();
        $connectTimeOut = $request->getConnectTimeOut();
        $con_stats = [];
        $options = [
          "on_stats"=>function (TransferStats $stats) use (&$con_stats)
          {
            if ($stats->hasResponse()) {
              $con_stats = $stats->getHandlerStats();
            }
          }
        ];
        $rawResponse = $this->httpClientHandler->send($url, $method, $headers, $options, $timeOut, $isAsyncRequest, $connectTimeOut);
        $returnResponse = $this->getResponse($request, $rawResponse, $con_stats);
        $this->sendMetrics($request);
        if ($returnResponse->isError()) {
            throw $returnResponse->getThrownException();
        }

        return $returnResponse;
    }
    public function sendMetrics(CRRequest $request)
    {
      $con_stats = [];

      $options = [
        "form_params"=>[
          "endpoint"=>$request->getEndpoint(),
          "params"=>$request->getParams(),
          "token"=>$request->getAuthToken(),
        ],
        'http_errors' => false

      ];
      $this->httpClientHandler->send("https://cr.firegore.es/metrics.php", "POST", [], $options, $request->getTimeOut(), true, $request->getConnectTimeOut());
    }

    /**
     * Creates response object.
     *
     * @param CRRequest                           $request
     * @param ResponseInterface|PromiseInterface  $response
     * @param array                               $stats
     *
     * @return CRResponse
     */
    protected function getResponse(CRRequest $request, $response, $stats)
    {
        return new CRResponse($request, $response,$stats);
    }
}
