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

    namespace CR\Objects\ConstantsObjects;
    use CR\Objects\BaseObject;

    /**
     * Class GameMode
     *
     * @method string getName()
     * @method string getCardLevelAdjustment()
     * @method string getDeckSelection()
     * @method int getOvertimeSeconds()
     * @method string getPredefinedDecks()
     * @method bool getSameDeckOnBoth()
     * @method bool getSeparateTeamDecks()
     * @method bool getSwappingTowers()
     * @method bool getUseStartingElixir()
     * @method bool getHeroes()
     * @method string getPlayers()
     * @method bool getGivesClanScore()
     * @method bool getFixedDeckOrder()
     * @method int getBattleStartCooldown()
     * @method int getId()
     * @method string getNameEn()
     * @method int getElixirProductionMultiplier()
     * @method int getStartingElixir()
     * @method string getClanWarDescription()
     * @method string getForcedDeckCards()
     * @method int getElixirProductionOvertimeMultiplier()
     * @method string getEventDeckSetLimit()
     * @method int getGoldPerTower1()
     * @method int getGoldPerTower2()
     * @method int getGoldPerTower3()
     * @method int getTargetTouchdowns()
     * @method string getSkinSet()
     * @method string getFixedArena()
     * @method int getGemsPerTower1()
     * @method int getGemsPerTower2()
     * @method int getGemsPerTower3()
     *
     * @package CR\Objects\ConstantsObjects
     */
    class GameMode extends BaseObject
    {
        /**
         * {@inheritdoc}
         */
        public function primaryKey()
        {
            return "";
        }


        /**
         * {@inheritdoc}
         */
        public function relations()
        {
            return [];
        }

    }
