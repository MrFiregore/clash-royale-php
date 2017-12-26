<?php
namespace CR;

use CR\CRClient;
use CR\CRRequest;
use CR\Exceptions\CRSDKException;
use CR\Objects\Clan;
use CR\Objects\Player;
use CR\Objects\Aliance;
use CR\Objects\Arena;
use CR\Objects\UnknownObject;
use CR\CRCache;


/**
 * [Api description]
 */

class Api
{
  protected $client;
  protected $auth_token;
  protected $last_response;

  /**
  * The max lifetime cache
  * @var int
  */
  protected $max_cache_age=120;

  function __construct($auth_token=null,$httpClientHandler = null)
  {
    if (is_null($auth_token)) throw new CRSDKException("Auth token is required, additional information and support: http://discord.me/cr_api", 1);
    $this->setAuthToken($auth_token);
    $this->client = new CRClient($httpClientHandler);
  }

  /**
   * @return mixed
   */
  public function getAuthToken()
  {
    return $this->auth_token;
  }

  /**
   * @param mixed $auth_token
   *
   * @return static
   */
  public function setAuthToken($auth_token)
  {
    $this->auth_token = $auth_token;
    return $this;
  }
  /**
   * @return int
   */
  public function getMaxCacheAge(): int
  {
    return $this->max_cache_age;
  }

  /**
   * @param int $max_cache_age
   *
   * @return static
   */
  public function setMaxCacheAge(int $max_cache_age)
  {
    $this->max_cache_age = $max_cache_age;
    return true;
  }

  protected function post($endpoint, array $params = [])
  {
    $file_cache = $endpoint."-".implode(",",$params);

    if (CRCache::exists($file_cache,["maxage"=>$this->max_cache_age])) {
      $response = unserialize(CRCache::get($file_cache));
    } else {
      $request = new CRRequest(
        $this->getAuthToken(),
        $endpoint,
        $params
      );
      $response = $this->client->sendRequest($request);
      if (!$response->isError()) {
        CRCache::write($file_cache,serialize($response));
      }

    }

    return $this->lastResponse = $response;
  }


  /**
  * Return the las response of the endpoint
  * @method getLastResponse
  * @return CRResponse
  */
  public function getLastResponse()
  {
    return $this->last_response;
  }

  /**
   * Return all the information about the given users tag
   * @method getPlayer
   * @param  array     $player         Array with the id of the profiles
   * @return array|Player              Array of Player Objects if given more than one profile, else return one Player Object
   */
   public function getPlayer(array $player)
   {
     $players = [];
     foreach ($player as $p) {
       $response = $this->post("player",[$p]);
       if (!$response->isError()) {
         $players[] = new Player($response->getDecodedBody());
       }
     }
     return count($players)>1 ? $players : $players[0];
   }
   /**
    * Return all the information about the given clan tag
    * @method getClan
    * @param  array  $clan       Array with the tag of the clans
    * @return array|Clan         Array of Clan Objects if given more than one profile, else return one Clan Object
    */
    public function getClan(array $clan)
    {
      $clans = [];
      foreach ($clan as $c) {
        $response = $this->post("clan",[$c]);
        if (!$response->isError()) {
          $clans[] = new Clan($response->getDecodedBody());
        }
      }
      return count($clans)>1 ? $clans : $clans[0];
    }

    /**
     * Return all information about the top players or clans
     * @method getTop
     * @param  array  $top  Array with values "players" or/and "clans"
     * @return array        Array with key of respectives top type ("players" or "clans") and with their values an array with "lastUpdate" of the top list and the respective array with the respective objects type ("players" = array CR\Objects\Player)
     */

    public function getTop(array $top)
    {
      $tops = [];
      foreach ($top as $t) {
        $response = $this->post("top",[$t]);
        if (!$response->isError()) {
          $object = studly_case(substr($t,0,-1));
          $class = 'CR\Objects\\'.$object;
          $response = $response->getDecodedBody();
          array_walk($response, function (&$value,$key) use ($class)
          {
            if (is_array($value)) {
              $new_value = [];
              foreach ($value as $k => $v) {
                $new_value[] = new $class($v);
              }
              $value = $new_value;
            }
          });
          $tops[$t] = $this->lastResponse = $response;
        }
      }
      return $tops;

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
        return new $class($response->getDecodedBody());
      }

      return $response;
    }
    $response = $this->post($method, $arguments[0]);

    return new UnknownObject($response->getDecodedBody());
  }
}
