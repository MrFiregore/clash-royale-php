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
use CR\CRClient;
use CR\CRRequest;
use CR\Objects\Endpoint;
use CR\Objects\AuthStats;
use CR\Objects\ChestCycle;
use CR\Exceptions\CRSDKException;
use CR\Exceptions\CRResponseException;
use CR\HttpClients\HttpClientInterface;
use CR\Objects\Clan;
use CR\Objects\Player;
use CR\Objects\ClanSearch;
use CR\Objects\UnknownObject;
use CR\CRCache;


/**
 * [Api description]
 */

class Api
{

  const API_VERSION = "1.2";
  /**
  * [protected description]
  * @var CRClient
  */
  protected $client;
  protected $auth_token;
  protected $last_response;
  protected static $endpoints = [];
  protected static $ping;
  protected static $last_ping;
  protected $limit = 260;
  protected $remaining = 260;

  /**
  * The max lifetime cache
  * @var int
  */
  protected $max_cache_age=120;

  function __construct(string $auth_token=null,int $max_cache_age = 120,HttpClientInterface $httpClientHandler = null)
  {
    if (is_null($auth_token)) throw new CRSDKException("Auth token is required, additional information and support: http://discord.me/cr_api", 1);
    $this->setAuthToken($auth_token);
    $this->setMaxCacheAge($max_cache_age);
    
    if (!CRCache::exists("APIVERSION".self::API_VERSION) || version_compare(self::API_VERSION,CRCache::get("APIVERSION".self::API_VERSION),">")) {
      CRUtils::delTree(CRCache::getPath());
      CRCache::write("APIVERSION".self::API_VERSION,self::API_VERSION);
    }
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
  /**
   * [post description]
   * @method post
   * @param  string       $endpoint [description]
   * @param  array        $params   [description]
   * @param  array        $querys   [description]
   * @return CRResponse             [description]
   */

  protected function post($endpoint, array $params = [], array $querys = [])
  {
    $base_file = str_replace(["/:tag/","/:tag","/",":tag"],"-",substr($endpoint,1));
    $base_file = (substr($base_file,-1) !== "-") ? $base_file."-" : $base_file;

    $response = [];
    $extension = md5(json_encode($querys));
    $should_save_separate = !empty($params);
    foreach ($params as $key => $value) {
      $file_cache = $base_file.$value.".".$extension;
      $condition = ($this->ping()) ? ["maxage"=>$this->max_cache_age] : [];

      if (CRCache::exists($file_cache,$condition)) {
        $response[] = json_decode(CRCache::get($file_cache),true);
        unset($params[$key]);
      }
    }
    $params = array_values($params);




    if ($should_save_separate && !empty($params)) {
      $request = new CRRequest(
        $this->getAuthToken(),
        $endpoint,
        $params,
        $querys
      );

      $this->lastResponse = $res = $this->client->sendRequest($request);
      if ($res->isError()) {
        throw new CRResponseException($res);
      }

      if (isset($res->getHeaders()['x-ratelimit-limit'])) {
        $this->limit = $res->getHeaders()['x-ratelimit-limit'][0];
      }
      if (isset($res->getHeaders()['x-ratelimit-remaining'])) {
        $this->remaining = $res->getHeaders()['x-ratelimit-remaining'][0];
      }
      if(CRUtils::isAssoc($res->getDecodedBody())){
        $file_cache = $base_file.$params[0].".".$extension;
        $response[] = $res->getDecodedBody();
        CRCache::write($file_cache,json_encode($res->getDecodedBody()));
      }
      else {
        foreach ($res->getDecodedBody() as $key => $resp) {
          $file_cache = $base_file.$params[$key].".".$extension;
          $response[] = $resp;
          CRCache::write($file_cache,json_encode($resp));

        }
      }
    }

    return  (count($response) === 1) ? $response[0] : $response;
  }


  /**
   * Check the server status
   * @method ping
   * @return bool Return true if the server is up, otherwise returns false
   */
  public function ping()
  {
    if (is_null(self::$ping) || is_null(self::$last_ping) || (time() - self::$last_ping) > 30) {
      self::$last_ping = time();
      self::$ping = $this->client->ping();
    }
    return self::$ping;
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
   * [getAuthStats description]
   * @method getAuthStats
   * @return AuthStats       [description]
   */

  public function getAuthStats()
  {
    $response = $this->post("/auth/stats");
    return new AuthStats($response);
  }
  /**
   * [getEndpoints description]
   * @method getEndpoints
   * @return Endpoint[]       [description]
   */

  public function getEndpoints()
  {
    if (empty(self::$endpoints)) {
      $response = $this->post("/endpoints");
      foreach ($response as $endpoint) {
        self::$endpoints[] = new Endpoint(["url"=>$endpoint]);
      }
    }
    return self::$endpoints;
  }


  /**
   * Return all the information about the given users tag
   * @method getPlayer
   * @param  array             $player          Array with the id of the profiles
   * @param  array             $keys            Array with the exact parameters to request
   * @param  array             $exclude         Array with the exact parameters to exclude in the request
   * @return Player[]||Player                   Array of Player Objects if given more than one profile, else return one Player Object
   */
   public function getPlayer(array $player,array $keys = [],array $exclude = [])
   {
     $players = [];
     $querys = [];

     if (!empty($keys)) $querys["keys"] = $keys;
     if (!empty($exclude)) $querys["exclude"] = $exclude;

     $response = $this->post("/player/:tag",$player,$querys);
     if(CRUtils::isAssoc($response)) return new Player($response);
     foreach ($response as $p) {
       $players[] = new Player($p);
     }
     return $players;
   }

   /**
    * Return all the information about the given users tag
    * @method getPlayer
    * @param  array     $player          Array with the id of the profiles
    * @param  array             $keys            Array with the exact parameters to request
    * @param  array             $exclude         Array with the exact parameters to exclude in the request
    * @return ChestCycle[]                   Array of ChestCycle Objects if given more than one profile, else return one ChestCycle Object
    */
    public function getPlayerChests(array $player,array $keys = [],array $exclude = [])
    {
      $players = [];
      $querys = [];

      if (!empty($keys)) $querys["keys"] = $keys;
      if (!empty($exclude)) $querys["exclude"] = $exclude;
      $response = $this->post("/player/:tag/chest",$player,$querys);

      if(CRUtils::isAssoc($response)) return new ChestCycle($response);
      foreach ($response as $p) {
        $players[] = new ChestCycle($p);
      }
      return $players;
    }

   /**
   * Return all the information about the given clan tag
   * @method getClan
   * @param  array          $clan       Array with the tag of the clans
   * @param  array          $keys            Array with the exact parameters to request
   * @param  array          $exclude         Array with the exact parameters to exclude in the request
   * @return Clan[]||Clan               Array of Clan Objects if given more than one profile, else return one Clan Object
   */
    public function getClan(array $clan,array $keys = [],array $exclude = [])
    {
      $clans = [];
      $querys = [];

      if (!empty($keys)) $querys["keys"] = $keys;
      if (!empty($exclude)) $querys["exclude"] = $exclude;

      $response = $this->post("/clan/:tag",$clan,$querys);
      if(CRUtils::isAssoc($response)) return new Clan($response);
      foreach ($response as $c) {
        $clans[] = new Clan($c);
      }
      return $clans;
    }
    /**
     * Search clans by their attributes
     * @method clanSearch
     * @param  string           $name                 (Optional)Clan name text search.
     * @param  int              $score                (Optional) Minimum clan score.
     * @param  int              $minMembers           (Optional) Minimum number of members. 0-50
     * @param  int              $maxMembers           (Optional) Maximum number of members. 0-50
     * @return ClanSearch[]     $clanSearch           Returns an array of Clan objects that match the search parameters
     */
    public function clanSearch(string $name = "", int $score = 0, int $minMembers = 0, int $maxMembers = 50)
    {
      $clanSearch = [];
      if (empty(func_get_args())) {
        throw new CRSDKException("This method (".__METHOD__.") must at least one parameter", 1);
        return false;

      }
      $reflection = new \ReflectionMethod(__CLASS__,last(explode("::",__METHOD__)));
      $query = [];

      foreach ($reflection->getParameters() as $key => $parameter) {
        if (isset(func_get_args()[$key])) {
          switch ($parameter->getType()->getName()) {
            case 'string':
              if (func_get_args()[$key] === "" || is_null(func_get_args()[$key])) {
                throw new CRSDKException("The parameter '".$parameter->getName()."' of the method (".__METHOD__.") can't be empty or null", 1);
                return false;
              }
              break;
          }
          $query[$parameter->getName()] = func_get_args()[$key];

        }
      }
      $response = $this->post("/clan/search",[],$query);
      foreach ($response as $cs) {
        $clanSearch[] = new ClanSearch($cs);
      }
      return $clanSearch;
    }

    /**
     * Return all information about the top players
     * @method getTopPlayers
     * @param  string  $location  Two-letter code of the location
     * @return array              Array with key of respectives top type ("players" or "clans") and with their values an array with "lastUpdate" of the top list and the respective array with the respective objects type ("players" = array CR\Objects\Player)
     */

    public function getTopPlayers(string $location = "")
    {
      $tops = [];
      $response = $this->post("/top/player",[$location]);
      foreach ($response as $p) {
        $tops[] = new Player($p);
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
        return new $class($response);
      }

      return new UnknownObject($response);
    }
  }
}
