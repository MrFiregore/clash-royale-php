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
     ~ If not, see <http://www.gnu.org/licenses/> 2018.06.13                                                                                                                                                                                                    ~
     ~                                                                                                                                                                                                                                                          ~
     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
    
    namespace CR\Objects;
    
    use CR\Objects\ConstantsObjects\Arena;

    /**
     * Class Battle.
     *
     * @method string   getType()
     * @method string   getChallengeType()
     * @method array    getMode()
     * @method int      getWinCountBefore()
     * @method int      getUtcTime()
     * @method string   getDeckType()
     * @method int      getTeamSize()
     * @method int      getWinner()
     * @method int      getTeamCrowns()
     * @method int      getOpponentCrowns()
     * @method Player[] getTeam()
     * @method Player[] getOpponent()
     * @method Arena    getArena()
     */
    class Battle extends BaseObject
    {
        protected static $stats = null;
        protected static $list  = null;
        
        /**
         * {@inheritdoc}
         */
        public function primaryKey ()
        {
            return 'utcTime';
        }
        
        /**
         * {@inheritdoc}
         */
        public function relations ()
        {
            return [
                'team'     => Player::class,
                'opponent' => Player::class,
                'arena'    => Arena::class,
            ];
        }
    }
