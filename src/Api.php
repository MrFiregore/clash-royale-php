<?php
namespace CR;
use CR\CRClient;
use CR\CRRequest;
use CR\Objects\Clan;
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
   * Return all the information about the given users id
   * @method getPRofile
   * @param  array     $profile Array with the id of the profiles
   * @return array|Profile              Array of Profile Objects if given more than one profile, else return one Profile Object
   */
   public function getPRofile(array $profile)
   {
     $profiles = [];

     foreach ($profile as $p) {
       $request = new CRRequest(
         "profile",
         [$p]
       );
       $response = $this->client->sendRequest($request);
       if (!$response->isError()) {
         $this->lastResponse = $profiles[] = new Profile($response->getDecodedBody());
       }
     }
     return count($profiles)>1 ? $profiles : $profiles[0];
   }
   /**
    * [getClan description]
    * @method getClan
    * @param  array  $clan [description]
    * @return array|Clan        [description]
    */
    public function getClan($clan)
    {
      $clans = [];

      foreach ($clan as $p) {
        $request = new CRRequest(
          "clan",
          [$p]
        );
        $response = $this->client->sendRequest($request);
        if (!$response->isError()) {
          $this->lastResponse = $clans[] = new Clan($response->getDecodedBody());
        }
      }
      return count($clans)>1 ? $clans : $clans[0];
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
