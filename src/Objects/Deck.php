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

    namespace CR\Objects;
    use CR\Objects\ConstantsObjects\Card;


    /**
     *  Card object
     * @method    string              getName()                       Returns the name of the Card.
     * @method    int                 getLevel()                      (Optional) Returns the level of the Card.
     * @method    int                 getMaxLevel()                   Returns the max level of the Card.
     * @method    int                 getCount()                      (Optional) Returns the amount of this Card.
     * @method    string              getRarity()                     Returns the rarity type of the Card.
     * @method    int                 getRequiredForUpgrade()         (Optional) Returns the total required amount of cards in this level to upgrade the Card.
     * @method    int                 getLeftToUpgrade()              (Optional) Returns the remaining number of cards in this level to upgrade the Card.
     * @method    string              getIcon()                       Returns the url icon of the Card.
     * @method    string              getKey()                        Returns the key of the Card.
     * @method    int                 getElixir()                     Returns the elixir cost of the Card.
     * @method    string              getType()                       Returns the type of the Card.
     * @method    int                 getArena()                      Returns the arena level to unlock the Card.
     * @method    int                 getDescription()                Returns the description of the Card.
     * @method    int                 getId()                         Returns the id of the Card.
     *
     * @method    array               getConstant()                   Returns the Card object constants
     * @method    int                 getUpgradeCost()                Returns the cost to upgrade de card
     * @method    int                 getUpgradeExp()                 Returns the remaining experience when upgrade
     * @method    array               getUpgradeStats()               Returns the card stats
     */


    class Deck extends BaseObject
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
            return [
                "cards" =>  Card::class,
            ];
        }
    }
