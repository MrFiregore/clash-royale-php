<?php /** @noinspection Annotator */
    
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
     ~                                                                                                                                                                                                                                                          ~
     ~ Copyright (c) 2018 by firegore (https://firegore.es) (git:firegore2)                                                                                                                                                                                     ~
     ~ This file is part of clash-royale-php.                                                                                                                                                                                                                   ~
     ~                                                                                                                                                                                                                                                          ~
     ~ clash-royale-php is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
     ~ clash-royale-php is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                                                                  ~
     ~ See the GNU Affero General Public License for more details.                                                                                                                                                                                              ~
     ~ You should have received a copy of the GNU General Public License along with clash-royale-php.                                                                                                                                                           ~
     ~ If not, see <http://www.gnu.org/licenses/> 2018.06.01                                                                                                                                                                                                    ~
     ~                                                                                                                                                                                                                                                          ~
     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    
    namespace CR;
    
    use CR\Exceptions\CRResponseException;
    use CR\Exceptions\CRSDKException;
    use CR\HttpClients\HttpClientInterface;
    use CR\Objects\AuthStats;
    use CR\Objects\Battle;
    use CR\Objects\Clan;
    use CR\Objects\ClanTracking;
    use CR\Objects\ClanWar;
    use CR\Objects\Constants;
    use CR\Objects\Deck;
    use CR\Objects\Endpoint;
    use CR\Objects\Health;
    use CR\Objects\History;
    use CR\Objects\Player;
    use CR\Objects\PlayerChest;
    use CR\Objects\Status;
    use CR\Objects\Tournament;
    use CR\Objects\UnknownObject;
    use CR\Traits\CacheTrait;
    use Gears\ClassFinder;
    use Illuminate\Support\Str;
    use ReflectionClass;
    
    /**
     * Api.
     *
     * @method Player|Player[] getPlayer(array $ids, array $keys = [], array $exclude = [])
     * @method Battle          getPlayerBattle(array $ids, array $keys = [], array $exclude = [])
     * @method PlayerChest     getPlayerChest(array $ids, array $keys = [], array $exclude = [])
     * @method Clan[]          getClanSearch(string $name, int $score, int $minMembers, int $maxMembers)
     * @method ClanTracking        getClanTracking(array $ids, array $keys = [], array $exclude = [])
     * @method Clan            getClan(array $ids, array $keys = [], array $exclude = [])
     * @method Battle          getClanBattle(array $ids, array $keys = [], array $exclude = [], string $type = "")
     * @method ClanWar         getClanWar(array $ids, array $keys = [], array $exclude = [])
     * @method ClanWar         getClanWarlog(array $ids, array $keys = [], array $exclude = [])
     * @method History         getClanHistory(array $ids, array $keys = [], array $exclude = [])
     * @method History         getClanHistoryWeekly(array $ids, array $keys = [], array $exclude = [])
     * @method UnknownObject   getClanTrack(array $ids, array $keys = [], array $exclude = [])
     * @method Tournament      getTournamentOpen(array $ids, array $keys = [], array $exclude = [])
     * @method Tournament      getTournamentKnown(array $ids, array $keys = [], array $exclude = [])
     * @method Tournament      getTournamentSearch(array $ids, array $keys = [], array $exclude = [])
     * @method Tournament      getTournament(array $ids, array $keys = [], array $exclude = [])
     * @method Clan[]          getTopClan(array $ids, array $keys = [], array $exclude = [])
     * @method Clan[]          getTopPlayer(string)
     * @method Clan[]          getPopularClan(array $ids, array $keys = [], array $exclude = [])
     * @method Player[]        getPopularPlayer(array $ids, array $keys = [], array $exclude = [])
     * @method Tournament[]    getPopularTournament(array $ids, array $keys = [], array $exclude = [])
     * @method Deck[]          getPopularDeck(array $ids, array $keys = [], array $exclude = [])
     * @method Constants       getConstant()
     * @method AuthStats       getAuthStats()
     * @method UnknownObject   getVersion(array $ids, array $keys = [], array $exclude = [])
     * @method Health          getHealth()
     * @method Status          getStatus(array $ids, array $keys = [], array $exclude = [])
     * @method Endpoint[]      getEndpoints()                    *
     */
    class Api
    {
        use CacheTrait;
        
        protected static $ping;
        protected static $last_ping;
        protected static $endpoints;
        protected static $default_endpoints =
            [
                '/players?/:tag'              => Player::class,
                '/players?/:tag/battles?'     => Battle::class,
                '/players?/:tag/chests?'      => PlayerChest::class,
                '/clans?/search'              => Clan::class,
                '/clans?/tracking'            => ClanTracking::class,
                '/clans?/:tag'                => Clan::class,
                '/clans?/:tag/battles?'       => Battle::class,
                '/clans?/:tag/war'            => ClanWar::class,
                '/clans?/:tag/warlog'         => ClanWar::class,
                '/clans?/:tag/history'        => History::class,
                '/clans?/:tag/history/weekly' => History::class,
                '/clans?/:tag/tracking'       => ClanTracking::class,
                '/clans?/:tag/track'          => UnknownObject::class,
                '/tournaments?/open'          => Tournament::class,
                '/tournaments?/known'         => Tournament::class,
                '/tournaments?/search'        => Tournament::class,
                '/tournaments?/:tag'          => Tournament::class,
                '/top/clans?/:cc?'            => Clan::class,
                '/top/players?/:cc?'          => Player::class,
                '/popular/clans?'             => Clan::class,
                '/popular/players?'           => Player::class,
                '/popular/tournaments?'       => Tournament::class,
                '/popular/decks?'             => Deck::class,
                '/constants?'                 => Constants::class,
                '/auth/stats'                 => AuthStats::class,
                '/version'                    => UnknownObject::class,
                '/health'                     => Health::class,
                '/status'                     => Status::class,
                '/endpoints'                  => Endpoint::class,
            ];
        /** @var CRClient $client */
        protected $client;
        protected $auth_token;
        protected $last_response;
        /**
         * The max lifetime cache.
         *
         * @var int
         */
        protected $max_cache_age = 120;
        
        public function __construct (
            string $auth_token = null,
            int $max_cache_age = null,
            HttpClientInterface $httpClientHandler = null
        ) {
            if (is_null($auth_token)) {
                throw new CRSDKException('Auth token is required, additional information and support: http://discord.me/cr_api', 1);
            }
            $this->setAuthToken($auth_token)
                 ->setMaxCacheAge($max_cache_age ?: 120);
            CRVersion::checkVersion();
            $this->client = new CRClient($httpClientHandler);
        }
        
        public static function getEndpointsStatic ()
        {
            return self::$endpoints;
        }
        
        public static function getDefaultEndpointsStatic ()
        {
            return self::$default_endpoints;
        }
        
        /**
         * @param string $method
         * @param        $arguments
         *
         * @return mixed
         * @throws \CR\Exceptions\CRResponseException
         * @throws \CR\Exceptions\CRSDKException
         */
        public function __call (string $method, $arguments)
        {
            $action         = substr($method, 0, 3);
            $endpoint_array = explode('_', Str::snake(substr($method, 3)));
            list($class, $endpoint) = $this->searchEndpoint($endpoint_array) ?: [UnknownObject::class, implode('/', $endpoint_array)];
            $response = $this->post($endpoint, ...$arguments);
            
            return new $class($response);
        }
        
        public function searchEndpoint (array $endpoint_array)
        {
            $endpoints = collect($this->getEndpoints());
            $endpoints = $endpoints->filter(
                function ($item, $value) use ($endpoint_array) {
                    /**
                     * @var Endpoint $item
                     */
                    $req     = count($endpoint_array);
                    $found   = 0;
                    $value_a = explode('/', $item->getPath());
                    foreach ($endpoint_array as $end) {
                        $found += in_array($end . 's', $value_a) || in_array($end, $value_a) ? 1 : 0;
                    }
                    
                    return $req == $found;
                }
            );
            if (!$endpoints->count()) {
                return false;
            }
            /**
             * @var Endpoint $endpoint
             */
            $endpoint   = current($endpoints->all());
            $class_name = \Illuminate\Support\Str::studly(strtolower($endpoint->getKey()));
            $class_name = Str::endsWith($class_name, "s") ? substr($class_name,0,-1): $class_name;
            $finder     = new ClassFinder(require CRUtils::getRoot() . "/vendor/autoload.php");
            $classes = $finder->namespace("CR")->filterBy(
                function (ReflectionClass $rClass) use ($class_name) {
                    
                    return $rClass->getShortName() ==$class_name;
                }
            )->search();
            $class = count($classes) ? current($classes) : UnknownObject::class;
            return [$class, $endpoint->getPath()];
        }
        
        /**
         * [getEndpoints description].
         *
         * @method getEndpoints
         *
         * @return Endpoint[] [description]
         * @throws \CR\Exceptions\CRResponseException
         * @throws \CR\Exceptions\CRSDKException
         */
        public function getEndpoints ()
        {
            if (empty(self::$endpoints)) {
                $response = $this->post('/endpoints');
                array_walk(
                    $response, function (&$endpoint, $key) {
                    $endpoint = new Endpoint($endpoint);
                }
                );
                self::$endpoints = array_values($response);
            }
            
            return self::$endpoints;
        }
        
        /**
         * [post description].
         *
         * @method post
         *
         * @param string $endpoint [description]
         * @param array  $params   [description]
         * @param array  $querys   [description]
         *
         * @return array [description]
         *
         * @throws \CR\Exceptions\CRResponseException
         * @throws \CR\Exceptions\CRSDKException
         */
        protected function post ($endpoint, array $params = [], array $querys = [])
        {
            $params = array_filter(
                $params,
                function ($var) {
                    return !is_null($var);
                }
            );
            
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
                
                if (isset($res->getHeaders()['X-Ratelimit-Limit'])) {
                    $this->limit = intval($res->getHeaders()['X-Ratelimit-Limit'][0]);
                }
                if (isset($res->getHeaders()['X-Ratelimit-Remaining'])) {
                    $this->remaining = intval($res->getHeaders()['X-Ratelimit-Remaining'][0]);
                }
                $this->saveCache($res->getDecodedBody(), $response);
            }
            
            return (1 === count($response)) ? $response[0] : $response;
        }
        
        /**
         * @return mixed
         */
        public function getAuthToken ()
        {
            return $this->auth_token;
        }
        
        /**
         * @param mixed $auth_token
         *
         * @return static
         */
        public function setAuthToken ($auth_token)
        {
            $this->auth_token = $auth_token;
            
            return $this;
        }
        
        /**
         * @return int
         */
        public function getMaxCacheAge ()
        {
            return $this->max_cache_age;
        }
        
        /**
         * @return static
         */
        public function setMaxCacheAge (int $max_cache_age)
        {
            $this->max_cache_age = $max_cache_age;
            
            return $this;
        }
        
        /**
         * Check the server status.
         *
         * @method ping
         *
         * @return bool Return true if the server is up, otherwise returns false
         */
        public function ping ()
        {
            if (is_null(self::$ping) || is_null(self::$last_ping) || (time() - self::$last_ping) > 30) {
                self::$last_ping = time();
                self::$ping      = $this->client->ping();
            }
            
            return self::$ping;
        }
        
        /**
         * Return the las response of the endpoint.
         *
         * @method getLastResponse
         *
         * @return CRResponse
         */
        public function getLastResponse ()
        {
            return $this->last_response;
        }
        
        /**
         * [getAuthStats description].
         *
         * @method getAuthStats
         *
         * @return AuthStats [description]
         * @throws \CR\Exceptions\CRResponseException
         * @throws \CR\Exceptions\CRSDKException
         */
        public function getAuthStats ()
        {
            $response = $this->post('/auth/stats');
            
            return new AuthStats($response);
        }
        
        /**
         * [getHealth description].
         *
         * @method getHealth
         *
         * @return Health [description]
         */
        public function getHealth ()
        {
            $response = $this->post('/health');
            
            return new Health($response);
        }
        
        /**
         * [getConstant description].
         *
         * @method getConstant
         *
         * @return Constants [description]
         */
        public function getConstant ()
        {
            $response = $this->post('/constant');
            
            return new Constants($response);
        }
        
        /**
         * Return all the information about the given users tag.
         *
         * @method getPlayer
         *
         * @param array $player  Array with the id of the profiles
         * @param array $keys    Array with the exact parameters to request
         * @param array $exclude Array with the exact parameters to exclude in the request
         *
         * @return Player|Player[] Array of Player Objects if given more than one profile, else return one Player Object
         */
        public function getPlayer (array $player, array $keys = [], array $exclude = [])
        {
            $players = [];
            $querys  = [];
            
            if (!empty($keys)) {
                $querys['keys'] = $keys;
            }
            if (!empty($exclude)) {
                $querys['exclude'] = $exclude;
            }
            
            $response = $this->post('/player/:tag', $player, $querys);
            if (CRUtils::isAssoc($response)) {
                return new Player($response);
            }
            foreach ($response as $p) {
                $players[] = new Player($p);
            }
            
            return $players;
        }
        
        /**
         * Return all the information about the given users tag.
         *
         * @method getPlayerChest
         *
         * @param array $player  Array with the id of the profiles
         * @param array $keys    Array with the exact parameters to request
         * @param array $exclude Array with the exact parameters to exclude in the request
         *
         * @return PlayerChest[] Array of PlayerChest Objects if given more than one profile, else return one PlayerChest Object
         */
        public function getPlayerChest (array $player, array $keys = [], array $exclude = [])
        {
            $players = [];
            $querys  = [];
            
            if (!empty($keys)) {
                $querys['keys'] = $keys;
            }
            if (!empty($exclude)) {
                $querys['exclude'] = $exclude;
            }
            $response = $this->post('/player/:tag/chest', $player, $querys);
            
            if (CRUtils::isAssoc($response)) {
                return new PlayerChest($response);
            }
            
            foreach ($response as $p) {
                $players[] = new PlayerChest($p);
            }
            
            return $players;
        }
        
        /**
         * Return all the battles the given users tag.
         *
         * @method getPlayerBattle
         *
         * @param array $player  Array with the id of the profiles
         * @param array $keys    Array with the exact parameters to request
         * @param array $exclude Array with the exact parameters to exclude in the request
         *
         * @return Battle[] Array of Battle Objects if given more than one profile, else return one Battle Object
         */
        public function getPlayerBattle (array $player, array $keys = [], array $exclude = [])
        {
            $players = [];
            $querys  = [];
            
            if (!empty($keys)) {
                $querys['keys'] = $keys;
            }
            if (!empty($exclude)) {
                $querys['exclude'] = $exclude;
            }
            $response = $this->post('/player/:tag/battles', $player, $querys);
            
            if (CRUtils::isAssoc($response)) {
                return new Battle($response);
            }
            
            foreach ($response as $p) {
                $players[] = new Battle($p);
            }
            
            return $players;
        }
        
        /**
         * Return all the information about the given clan tag.
         *
         * @method getClan
         *
         * @param array $clan    Array with the tag of the clans
         * @param array $keys    Array with the exact parameters to request
         * @param array $exclude Array with the exact parameters to exclude in the request
         *
         * @return Clan|Clan[] Array of Clan Objects if given more than one profile, else return one Clan Object
         */
        public function getClan (array $clan, array $keys = [], array $exclude = [])
        {
            $clans  = [];
            $querys = [];
            
            if (!empty($keys)) {
                $querys['keys'] = $keys;
            }
            if (!empty($exclude)) {
                $querys['exclude'] = $exclude;
            }
            
            $response = $this->post('/clan/:tag', $clan, $querys);
            if (CRUtils::isAssoc($response)) {
                return new Clan($response);
            }
            foreach ($response as $c) {
                $clans[] = new Clan($c);
            }
            
            return $clans;
        }
        
        /**
         * Return all the information about the given clan tag.
         *
         * @method getClanBattles
         *
         * @param array  $clan    Array with the tag of the clans
         * @param array  $keys    Array with the exact parameters to request
         * @param array  $exclude Array with the exact parameters to exclude in the request
         * @param string $type    Type of clan battles to filter ('all', 'war' or 'clanMate')
         *
         * @return Clan[]||Clan Array of Clan Objects if given more than one profile, else return one Clan Object
         */
        public function getClanBattle (array $clan, array $keys = [], array $exclude = [], string $type = '')
        {
            $clans  = [];
            $querys = [];
            
            if (!empty($keys)) {
                $querys['keys'] = $keys;
            }
            if (!empty($exclude)) {
                $querys['exclude'] = $exclude;
            }
            if ('' !== $type) {
                $querys['type'] = $type;
            }
            
            $response = $this->post('/clan/:tag/battles', $clan, $querys);
            
            if (CRUtils::isAssoc($response)) {
                return new Battle($response);
            }
            foreach ($response as $c) {
                $clans[] = new Battle($c);
            }
            
            return $clans;
        }
        
        /**
         * Return all the information about the war of the given clan tag.
         *
         * @method getClanWar
         *
         * @param array $clan    Array with the tag of the clans
         * @param array $keys    Array with the exact parameters to request
         * @param array $exclude Array with the exact parameters to exclude in the request
         *
         * @return ClanWar|ClanWar[] Array of ClanWar Objects if given more than one profile, else return one ClanWar Object
         */
        public function getClanWar (array $clan, array $keys = [], array $exclude = [])
        {
            $clans  = [];
            $querys = [];
            
            if (!empty($keys)) {
                $querys['keys'] = $keys;
            }
            if (!empty($exclude)) {
                $querys['exclude'] = $exclude;
            }
            
            $response = $this->post('/clan/:tag/war', $clan, $querys);
            if (CRUtils::isAssoc($response)) {
                return new ClanWar($response);
            }
            foreach ($response as $c) {
                $clans[] = new ClanWar($c);
            }
            
            return $clans;
        }
        
        /**
         * Return all the information about the logs wars of the given clan tag.
         *
         * @method getClanWarLog
         *
         * @param array $clan    Array with the tag of the clans
         * @param array $keys    Array with the exact parameters to request
         * @param array $exclude Array with the exact parameters to exclude in the request
         *
         * @return ClanWar[] Array of ClanWar Objects if given more than one profile, else return one ClanWar Object
         */
        public function getClanWarLog (array $clan, array $keys = [], array $exclude = [])
        {
            $clans  = [];
            $querys = [];
            
            if (!empty($keys)) {
                $querys['keys'] = $keys;
            }
            if (!empty($exclude)) {
                $querys['exclude'] = $exclude;
            }
            
            $response = $this->post('/clan/:tag/warlog', $clan, $querys);
            if (CRUtils::isAssoc($response)) {
                return new ClanWar($response);
            }
            foreach ($response as $c) {
                $clans[] = new ClanWar($c);
            }
            
            return $clans;
        }
        
        /**
         * Search clans by their attributes.
         *
         * @method getClanSearch
         *
         * @param string $name       (Optional)Clan name text search
         * @param int    $score      (Optional) Minimum clan score
         * @param int    $minMembers (Optional) Minimum number of members. 0-50
         * @param int    $maxMembers (Optional) Maximum number of members. 0-50
         *
         * @return Clan[] Returns an array of Clan objects that match the search parameters
         */
        public function getClanSearch (string $name = '', int $score = 0, int $minMembers = 0, int $maxMembers = 50)
        {
            $clanSearch = [];
            if (empty(func_get_args())) {
                throw new CRSDKException('This method (' . __METHOD__ . ') must at least one parameter', 1);
                
                return false;
            }
            $reflection = new \ReflectionMethod(__CLASS__, last(explode('::', __METHOD__)));
            $query      = [];
            
            foreach ($reflection->getParameters() as $key => $parameter) {
                if (isset(func_get_args()[$key])) {
                    switch ($parameter->getType()->getName()) {
                        case 'string':
                            if ('' === func_get_args()[$key] || is_null(func_get_args()[$key])) {
                                throw new CRSDKException("The parameter '" . $parameter->getName() . "' of the method (" . __METHOD__ . ") can't be empty or null", 1);
                                
                                return false;
                            }
                            
                            break;
                    }
                    $query[$parameter->getName()] = func_get_args()[$key];
                }
            }
            $response = $this->post('/clan/search', [], $query);
            foreach ($response as $cs) {
                $clanSearch[] = new Clan($cs);
            }
            
            return $clanSearch;
        }
        
        /**
         * Return all information about the top players.
         *
         * @method getTopPlayer
         *
         * @param string||null $location Two-letter code of the location
         *
         * @return array Array with key of respectives top type ("players" or "clans") and with their values an array with "lastUpdate" of the top list and the
         *               respective array with the respective objects type ("players" = array CR\Objects\Player)
         */
        public function getTopPlayer (string $location = null)
        {
            $tops     = [];
            $response = $this->post('/top/player/:cc', [$location]);
            foreach ($response as $p) {
                $tops[] = new Player($p);
            }
            
            return $tops;
        }
        
        /**
         * @param array $player
         * @param array $keys
         * @param array $exclude
         * @param bool  $useCache
         *
         * @return Battle|Battle[]
         *
         * @throws \CR\Exceptions\CRResponseException
         * @throws \CR\Exceptions\CRSDKException
         */
        public function getPlayerBattlesNew (array $player, array $keys = [], array $exclude = [])
        {
            $battles = [];
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
                $battles[] = new Battle($p);
            }
            
            return $battles;
        }
        
        /**
         * @param array $constants
         * @param array $keys
         * @param array $exclude
         *
         * @return Constants
         * @throws \CR\Exceptions\CRResponseException
         * @throws \CR\Exceptions\CRSDKException
         */
        public function getConstants (array $constants, array $keys = [], array $exclude = [])
        {
            $querys = [];
            
            if (!empty($keys)) {
                $querys["keys"] = $keys;
            }
            if (!empty($exclude)) {
                $querys["exclude"] = $exclude;
            }
            $response = $this->post("/constants", $constants, $querys);
            
            return new Constants($response);
        }
    }
