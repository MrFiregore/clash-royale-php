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

use CR\Traits\CacheTrait;
use CR\Objects\Battle;
use CR\Objects\Helath;
use CR\Objects\ClanWar;
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

/**
 * [Api description]
 */
class Api
{
    use CacheTrait;

    /** @var  CRClient $client */
    protected $client;
    protected $auth_token;
    protected $last_response;
    protected static $endpoints = [];
    protected static $ping;
    protected static $last_ping;


    /**
     * The max lifetime cache
     * @var int
     */
    protected $max_cache_age = 120;

    /**
     * Api constructor.
     * @param string|null $auth_token
     * @param int $max_cache_age
     * @param HttpClientInterface|null $httpClientHandler
     * @throws CRSDKException
     */
    public function __construct(string $auth_token = null, int $max_cache_age = null, HttpClientInterface $httpClientHandler = null)
    {
        if (is_null($auth_token)) {
            throw new CRSDKException("Auth token is required, additional information and support: http://discord.me/cr_api", 1);
        }
        $this->setAuthToken($auth_token);
        $this->setMaxCacheAge($max_cache_age ?: 120);
        CRVersion::checkVersion();
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
    public function getMaxCacheAge()
    {
        return $this->max_cache_age;
    }

    /**
     * @param int $max_cache_age
     *
     * @return bool
     */
    public function setMaxCacheAge(int $max_cache_age)
    {
        $this->max_cache_age = $max_cache_age;

        return true;
    }

    /**
     * [post description]
     * @method post
     * @param  string $endpoint [description]
     * @param  array $params [description]
     * @param  array $querys [description]
     * @return array|CRResponse
     * @throws CRResponseException
     */
    protected function post($endpoint, array $params = [], array $querys = [])
    {
        $params   = array_filter($params, function ($var) {
            return !is_null($var);
        });
        $response = $this->checkCache($endpoint, $params, $querys);
        if ((empty($response) && empty($params)) || !empty($params)) {
            $request = new CRRequest(
                $this->getAuthToken(),
                $endpoint,
                $params,
                $querys
            );

            $this->last_response = $res = $this->client->sendRequest($request);


            if ($res->isError()) {
                throw new CRResponseException($res);
            }

            $this->saveCache($res->getDecodedBody(), $response);
        }

        return (count($response) === 1) ? $response[0] : $response;
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
            self::$ping      = $this->client->ping();
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
     * [getHealth description]
     * @method getHealth
     * @return Helath       [description]
     */
    public function getHealth()
    {
        $response = $this->post("/health");

        return new Helath($response);
    }

    /**
     * [getConstant description]
     * @method getConstant
     * @return Helath|UnknownObject
     */
    public function getConstant()
    {
        $response = $this->post("/constant");

        return new UnknownObject($response);
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
                self::$endpoints[] = new Endpoint(["url" => $endpoint]);
            }
        }

        return self::$endpoints;
    }


    /**
     * Return all the information about the given users tag
     * @method getPlayer
     *
     * @param  array $player Array with the id of the profiles
     * @param  array $keys Array with the exact parameters to request
     * @param  array $exclude Array with the exact parameters to exclude in the request
     *
     * @return Player[]|Player                   Array of Player Objects if given more than one profile, else return
     *                                           one Player Object
     * @throws \CR\Exceptions\CRResponseException
     */
    public function getPlayer(array $player, array $keys = [], array $exclude = [])
    {
        $players = [];
        $querys  = [];

        if (!empty($keys)) {
            $querys["keys"] = $keys;
        }
        if (!empty($exclude)) {
            $querys["exclude"] = $exclude;
        }

        $response = $this->post("/player/:tag", $player, $querys);
        if (CRUtils::isAssoc($response)) {
            return new Player($response);
        }
        foreach ($response as $p) {
            $players[] = new Player($p);
        }

        return $players;
    }

    /**
     * Return all the information about the given users tag
     * @method getPlayerChests
     * @param  array $player Array with the id of the profiles
     * @param  array $keys Array with the exact parameters to request
     * @param  array $exclude Array with the exact parameters to exclude in the request
     * @return ChestCycle[]|ChestCycle                   Array of ChestCycle Objects if given more than one profile, else return one ChestCycle Object
     */
    public function getPlayerChests(array $player, array $keys = [], array $exclude = [])
    {
        $players = [];
        $querys  = [];

        if (!empty($keys)) {
            $querys["keys"] = $keys;
        }
        if (!empty($exclude)) {
            $querys["exclude"] = $exclude;
        }
        $response = $this->post("/player/:tag/chest", $player, $querys);

        if (CRUtils::isAssoc($response)) {
            return new ChestCycle($response);
        }

        foreach ($response as $p) {
            $players[] = new ChestCycle($p);
        }

        return $players;
    }

    /**
     * Return all the battles the given users tag
     * @method getPlayerBattles
     * @param  array $player Array with the id of the profiles
     * @param  array $keys Array with the exact parameters to request
     * @param  array $exclude Array with the exact parameters to exclude in the request
     * @return Battle[]|Battle            Array of Battle Objects if given more than one profile, else return one Battle Object
     */
    public function getPlayerBattles(array $player, array $keys = [], array $exclude = [])
    {
        $players = [];
        $querys  = [];

        if (!empty($keys)) {
            $querys["keys"] = $keys;
        }
        if (!empty($exclude)) {
            $querys["exclude"] = $exclude;
        }
        $response = $this->post("/player/:tag/battles", $player, $querys);

        if (CRUtils::isAssoc($response)) {
            return new Battle($response);
        }

        foreach ($response as $p) {
            $players[] = new Battle($p);
        }

        return $players;
    }

    /**
     * Return all the information about the given clan tag
     * @method getClan
     * @param  array $clan Array with the tag of the clans
     * @param  array $keys Array with the exact parameters to request
     * @param  array $exclude Array with the exact parameters to exclude in the request
     * @return Clan[]|Clan               Array of Clan Objects if given more than one profile, else return one Clan Object
     */
    public function getClan(array $clan, array $keys = [], array $exclude = [])
    {
        $clans  = [];
        $querys = [];

        if (!empty($keys)) {
            $querys["keys"] = $keys;
        }
        if (!empty($exclude)) {
            $querys["exclude"] = $exclude;
        }

        $response = $this->post("/clan/:tag", $clan, $querys);
        if (CRUtils::isAssoc($response)) {
            return new Clan($response);
        }
        foreach ($response as $c) {
            $clans[] = new Clan($c);
        }

        return $clans;
    }

    /**
     * Return all the information about the given clan tag
     * @method getClanBattles
     * @param  array $clan Array with the tag of the clans
     * @param  array $keys Array with the exact parameters to request
     * @param  array $exclude Array with the exact parameters to exclude in the request
     * @param  string $type Type of clan battles to filter ('all', 'war' or 'clanMate')
     * @return Battle[]|Battle                    Array of Clan Objects if given more than one profile, else return one Clan Object
     */
    public function getClanBattles(array $clan, array $keys = [], array $exclude = [], string $type = "")
    {
        $battles = [];
        $querys  = [];

        if (!empty($keys)) {
            $querys["keys"] = $keys;
        }
        if (!empty($exclude)) {
            $querys["exclude"] = $exclude;
        }
        if ($type !== "") {
            $querys["type"] = $type;
        }

        $response = $this->post("/clan/:tag/battles", $clan, $querys);

        if (CRUtils::isAssoc($response)) {
            return new Battle($response);
        }
        foreach ($response as $c) {
            $battles[] = new Battle($c);
        }

        return $battles;
    }

    /**
     * Return all the information about the war of the given clan tag
     * @method getClanWar
     * @param  array $clan Array with the tag of the clans
     * @param  array $keys Array with the exact parameters to request
     * @param  array $exclude Array with the exact parameters to exclude in the request
     * @return ClanWar[]|ClanWar                  Array of ClanWar Objects if given more than one profile, else return one ClanWar Object
     */
    public function getClanWar(array $clan, array $keys = [], array $exclude = [])
    {
        $clans  = [];
        $querys = [];

        if (!empty($keys)) {
            $querys["keys"] = $keys;
        }
        if (!empty($exclude)) {
            $querys["exclude"] = $exclude;
        }

        $response = $this->post("/clan/:tag/war", $clan, $querys);
        if (CRUtils::isAssoc($response)) {
            return new ClanWar($response);
        }
        foreach ($response as $c) {
            $clans[] = new ClanWar($c);
        }

        return $clans;
    }


    /**
     * Return all the information about the logs wars of the given clan tag
     * @method getClanWarLog
     * @param  array $clan Array with the tag of the clans
     * @param  array $keys Array with the exact parameters to request
     * @param  array $exclude Array with the exact parameters to exclude in the request
     * @return ClanWar[]|ClanWar                   Array of ClanWar Objects if given more than one profile, else return one ClanWar Object
     */
    public function getClanWarLog(array $clan, array $keys = [], array $exclude = [])
    {
        $clans  = [];
        $querys = [];

        if (!empty($keys)) {
            $querys["keys"] = $keys;
        }
        if (!empty($exclude)) {
            $querys["exclude"] = $exclude;
        }

        $response = $this->post("/clan/:tag/warlog", $clan, $querys);
        if (CRUtils::isAssoc($response)) {
            return new ClanWar($response);
        }
        foreach ($response as $c) {
            $clans[] = new ClanWar($c);
        }

        return $clans;
    }


    /**
     * Search clans by their attributes
     * @method clanSearch
     * @param  string $name (Optional)Clan name text search.
     * @param  int $score (Optional) Minimum clan score.
     * @param  int $minMembers (Optional) Minimum number of members. 0-50
     * @param  int $maxMembers (Optional) Maximum number of members. 0-50
     * @return bool|ClanSearch[] $clanSearch           Returns an array of Clan objects that match the search parameters
     * @throws CRSDKException
     */
    public function clanSearch(string $name = "", int $score = 0, int $minMembers = 0, int $maxMembers = 50)
    {
        $clanSearch = [];
        if (empty(func_get_args())) {
            throw new CRSDKException("This method (" . __METHOD__ . ") must at least one parameter", 1);

//            return false;
        }
        $reflection = new \ReflectionMethod(__CLASS__, last(explode("::", __METHOD__)));
        $query      = [];

        foreach ($reflection->getParameters() as $key => $parameter) {
            if (isset(func_get_args()[$key])) {
                switch ($parameter->getType()->getName()) {
                    case 'string':
                        if (func_get_args()[$key] === "" || is_null(func_get_args()[$key])) {
                            throw new CRSDKException("The parameter '" . $parameter->getName() . "' of the method (" . __METHOD__ . ") can't be empty or null", 1);

//                            return false;
                        }
                        break;
                }
                $query[$parameter->getName()] = func_get_args()[$key];
            }
        }

        $response = $this->post("/clan/search", [], $query);

        foreach ($response as $cs) {
            $clanSearch[] = new ClanSearch($cs);
        }

        return $clanSearch;
    }

    /**
     * Return all information about the top players
     * @method getTopPlayers
     * @param string|null $location
     * @return array Array with key of respectives top type ("players" or "clans") and with their values an array with "lastUpdate" of the top list and the respective array with the respective objects type ("players" = array CR\Objects\Player)
     * @internal param $ string||null  $location  Two-letter code of the location
     */
    public function getTopPlayers(string $location = null)
    {
        $tops     = [];
        $response = $this->post("/top/player/:cc", [$location]);
        foreach ($response as $p) {
            $tops[] = new Player($p);
        }

        return $tops;
    }

    /**
     * @param $method
     * @param $arguments
     * @return UnknownObject
     * @throws CRResponseException
     */
    public function __call($method, $arguments)
    {
        $action = substr($method, 0, 3);

        if ($action === 'get') {
            $class_name = studly_case(substr($method, 3));
            $class      = 'CR\Objects\\' . $class_name;
            $response   = $this->post($class_name, $arguments[0] ?: []);

            if (class_exists($class)) {
                return new $class($response);
            }

            return new UnknownObject($response);
        }

        return null;
    }
}
