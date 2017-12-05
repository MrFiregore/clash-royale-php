<?php
namespace CR;
use CR\CRClient;
use CR\CRRequest;
use CR\Objects\Profile;
use CR\Objects\Aliance;
use CR\Objects\Arena;
use CR\Objects\UnknownObject;

/**
 *
 */
class Api
{
  protected $client;
  protected $last_response;

  function __construct()
  {
    $this->client = new CRClient($httpClientHandler);
  }
  protected function post($endpoint, array $params = [])
  {
    $request = new CRRequest(
            $endpoint,
            $params
          );
          d($request);

    return $this->lastResponse = $this->client->sendRequest($request);
  }
  /**
   * [getPRofile description]
   * @method getPRofile
   * @param  array     $profile [description]
   * @return array              [description]
   */

    public function getPRofile($profile)
    {
      $profiles = [];

      foreach ($profile as $p) {
        $request = new CRRequest(
          "profile",
          [$p]
        );
        $response = $this->client->sendRequest($request);
        // d($p,$request;
        if (!$response->isError()) {
          $this->lastResponse = $profiles[] = new Profile($response->getDecodedBody());
        }
      }
      return count($profiles)>1 ? $profiles : $profiles[0];
    }
  public function __call($method, $arguments)
  {
    $action = substr($method, 0, 3);
    if ($action === 'get') {
      /* @noinspection PhpUndefinedFunctionInspection */
      $class_name = studly_case(substr($method, 3));
      $class = 'CR\Objects\\'.$class_name;
      $response = $this->post($class_name, $arguments[0] ?: []);

      if (class_exists($class)) {
        d($method,$class_name,$class,$response,class_exists($class));//getProfile Profile CR\Objects\Profile
        return new $class($response->getDecodedBody());
      }

      return $response;
    }
    $response = $this->post($method, $arguments[0]);

    return new UnknownObject($response->getDecodedBody());
  }
}
