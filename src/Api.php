<?php
namespace CR;

use CR\CRClient;
use CR\CRRequest;
use CR\Exceptions\CRSDKException;
use CR\HttpClients\HttpClientInterface;
use CR\Objects\Clan;
use CR\Objects\Player;
use CR\Objects\Aliance;
use CR\Objects\Arena;
use CR\Objects\ClanSearch;
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

  function __construct(string $auth_token=null,int $max_cache_age = 120,HttpClientInterface $httpClientHandler = null)
  {
    if (is_null($auth_token)) throw new CRSDKException("Auth token is required, additional information and support: http://discord.me/cr_api", 1);
    $this->setAuthToken($auth_token);
    $this->setMaxCacheAge($max_cache_age);
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
    $file_cache = $endpoint."-".str_replace("?","+",implode(",",$params));

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
   * @param  array     $player          Array with the id of the profiles
   * @param  array     $keys            Array with the exact parameters to request
   * @param  array     $exclude         Array with the exact parameters to exclude in the request
   * @return Player[]                   Array of Player Objects if given more than one profile, else return one Player Object
   */
   public function getPlayer(array $player,array $keys = [],array $exclude = [])
   {
     $players = [];
     $query = implode(",",$player).( (empty($keys)) ? "" : "?keys=".implode(",",$keys)).( (empty($exclude)) ? "" : "?exclude=".implode(",",$exclude));
     $response = $this->post("player",[$query]);
     if (!$response->isError()) {
       foreach ($response->getDecodedBody() as $p) {
         $players[] = new Player($p);
       }
     }
     return $players;
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
      $query = implode(",",$clan);
      $response = $this->post("clan",[$query]);
      if (!$response->isError()) {
        if (count($clan)>1) {
          foreach ($response->getDecodedBody() as $c) {
            $clans[] = new Clan($c);
          }
        }
        else $clans = new Clan($response->getDecodedBody());
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
      $query = "";
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
          $query .= ($query === "") ? $parameter->getName()."=".func_get_args()[$key] : "&".$parameter->getName()."=".func_get_args()[$key];
        }
      }
      $query = "search?".$query;
      $response = $this->post("clan",[$query]);
      if (!$response->isError()) {
        foreach ($response->getDecodedBody() as $cs) {
          $clanSearch[] = new ClanSearch($cs);
        }
      }
      return $clanSearch;
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
