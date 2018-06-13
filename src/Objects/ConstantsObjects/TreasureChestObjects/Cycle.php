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
     * Class Cycle
     *
     * @method string getName()
     * @method null getBaseChest()
     * @method array getArena()
     * @method boolean getInShop()
     * @method boolean getInArenaInfo()
     * @method boolean getTournamentChest()
     * @method boolean getSurvivalChest()
     * @method integer getShopPriceWithoutSpeedUp()
     * @method integer getTimeTakenDays()
     * @method integer getTimeTakenHours()
     * @method integer getTimeTakenMinutes()
     * @method integer getTimeTakenSeconds()
     * @method integer getRandomSpells()
     * @method integer getDifferentSpells()
     * @method integer getChestCountInChestCycle()
     * @method integer getRareChance()
     * @method integer getEpicChance()
     * @method integer getLegendaryChance()
     * @method integer getSkinChance()
     * @method null getGuaranteedSpells()
     * @method integer getMinGoldPerCard()
     * @method integer getMaxGoldPerCard()
     * @method null getSpellSet()
     * @method integer getExp()
     * @method integer getSortValue()
     * @method boolean getSpecialOffer()
     * @method boolean getDraftChest()
     * @method boolean getBoostedChest()
     * @method integer getLegendaryOverrideChance()
     * @method string getDescription()
     * @method string getNotification()
     * @method integer getCardCount()
     * @method integer getMinGold()
     * @method integer getMaxGold()
     * @method array getArenas()
     *
     * @package CR\Objects\ConstantsObjects
     */
    class Cycle extends BaseObject
    {
        /**
         * {@inheritdoc}
         */
        public function primaryKey ()
        {
            return "key";
        }

        /**
         * {@inheritdoc}
         */
        public function relations ()
        {
            return [];
        }
    }
