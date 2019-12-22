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
    
    namespace CR\Objects\ConstantsObjects\TreasureChestObjects;
    
    use CR\Objects\BaseObject;

    /**
     * Class Cycle.
     *
     * @method string getName()
     * @method null   getBaseChest()
     * @method array  getArena()
     * @method bool   getInShop()
     * @method bool   getInArenaInfo()
     * @method bool   getTournamentChest()
     * @method bool   getSurvivalChest()
     * @method int    getShopPriceWithoutSpeedUp()
     * @method int    getTimeTakenDays()
     * @method int    getTimeTakenHours()
     * @method int    getTimeTakenMinutes()
     * @method int    getTimeTakenSeconds()
     * @method int    getRandomSpells()
     * @method int    getDifferentSpells()
     * @method int    getChestCountInChestCycle()
     * @method int    getRareChance()
     * @method int    getEpicChance()
     * @method int    getLegendaryChance()
     * @method int    getSkinChance()
     * @method null   getGuaranteedSpells()
     * @method int    getMinGoldPerCard()
     * @method int    getMaxGoldPerCard()
     * @method null   getSpellSet()
     * @method int    getExp()
     * @method int    getSortValue()
     * @method bool   getSpecialOffer()
     * @method bool   getDraftChest()
     * @method bool   getBoostedChest()
     * @method int    getLegendaryOverrideChance()
     * @method string getDescription()
     * @method string getNotification()
     * @method int    getCardCount()
     * @method int    getMinGold()
     * @method int    getMaxGold()
     * @method array  getArenas()
     */
    class Cycle extends BaseObject
    {
        /**
         * {@inheritdoc}
         */
        public function primaryKey ()
        {
            return 'key';
        }
        
        /**
         * {@inheritdoc}
         */
        public function relations ()
        {
            return [];
        }
    }
