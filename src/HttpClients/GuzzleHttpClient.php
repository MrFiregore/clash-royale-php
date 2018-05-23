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
namespace CR\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Handler\StreamHandler;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use CR\Exceptions\CRSDKException;

/**
 * Class GuzzleHttpClient.
 */
class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * HTTP client.
     *
     * @var Client
     */
    protected $client;

    /**
     * @var PromiseInterface[]
     */
    private static $promises = [];

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
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * Unwrap Promises.
     */
    public function __destruct()
    {
      $results = [];
      foreach (self::$promises as $key => $promise) {
        try {
          $results[$key] = $promise->wait();
        }
        catch (ConnectException $e) {
          if ($e->getRequest()->getUri()->getHost() !== "cr.firegore.es") {
            throw $e;
          }
        }
      }

    }

    /**
     * Sets HTTP client.
     *
     * @param Client $client
     *
     * @return GuzzleHttpClient
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Gets HTTP client for internal class use.
     *
     * @return Client
     */
    private function getClient()
    {
        return $this->client;
    }
    /**
     * Check the server status
     * @method ping
     * @param  string   $url  The url server to check
     * @return bool           Return true if is up, otherwise returns false
     */

    public function ping($url)
    {
        $res = $this->getClient()->request("GET", $url, ['http_errors' => false]);
        return ($res->getStatusCode()<500);
    }

    /**
     * {@inheritdoc}
     */
    public function send(
        $url,
        $method,
        array $options = [],
        $timeOut = 30,
        $isAsyncRequest = false,
        $connectTimeOut = 10
    ) {
        $this->timeOut = $timeOut;
        $this->connectTimeOut = $connectTimeOut;

        $body = isset($options['body']) ? $options['body'] : null;
        $options = $this->getOptions($body, $options, $timeOut, $isAsyncRequest, $connectTimeOut);
        try {
            $response = $this->getClient()->requestAsync($method, $url, $options);
            if ($isAsyncRequest) {
                self::$promises[] = $response;
            } else {
                $response = $response->wait();
            }
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if (!$response instanceof ResponseInterface) {
                throw new CRSDKException($e->getMessage(), $e->getCode());
            }
        }

        return $response;
    }

    /**
     * Prepares and returns request options.
     *
     * @param  string $body
     * @param  array  $options
     * @param  int    $timeOut
     * @param  bool   $isAsyncRequest
     * @param  int    $connectTimeOut
     *
     * @return array
     */
    private function getOptions($body, $options, $timeOut, $isAsyncRequest = false, $connectTimeOut = 10)
    {
        $default_options = [
            RequestOptions::BODY            => $body,
            RequestOptions::TIMEOUT         => $timeOut,
            RequestOptions::CONNECT_TIMEOUT => $connectTimeOut,
            RequestOptions::SYNCHRONOUS     => !$isAsyncRequest,
        ];

        return array_merge($default_options, $options);
    }

    /**
     * @return int
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * @return int
     */
    public function getConnectTimeOut()
    {
        return $this->connectTimeOut;
    }
}
