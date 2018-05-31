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

    namespace CR\Objects\ConstantsObjects;
    use CR\Objects\BaseObject;
    use CR\CRConstant;


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


    class Card extends BaseObject
    {
        protected static $constants_stats= null;
        protected static $constants_rarities= null;
        protected $constant = null;

        /**
         * {@inheritdoc}
         */
        public function primaryKey()
        {
            return "id";
        }


        /**
         * {@inheritdoc}
         */
        public function relations()
        {
            return [
            ];
        }

        /**
         * [getConstant description]
         * @method getConstant
         * @return array      Returns an array of Card object constants
         */
        public function getConstant()
        {
            if (is_null(self::$constants_stats)) {
                self::$constants_stats = collect(CRConstant::getConstant("cards_stats"))
                    ->transform(function ($item,$key)
                    {
                        foreach ($item as $c_key => $card) {
                            $item[$c_key]['name'] = strtolower($card['name']);
                        }
                        return $item;
                    });
            }
            if (is_null(self::$constants_rarities)) {
                self::$constants_rarities = collect(CRConstant::getConstant("rarities"));
            }

            if (is_null($this->constant)) {
                $stats = collect(self::$constants_stats->get(strtolower($this->getType())))->where("name",$this->getKey())->values()->all();
                $this->constant['stats'] = (empty($stats)) ? $stats : $stats[0];
                $constants = self::$constants_rarities->where("name",$this->getRarity())->values()->all();
                $this->constant['constants'] = (empty($constants)) ? $constants : $constants[0];
            }
            return $this->constant;
        }

        public function getUpgradeCost()
        {
            $level = $this->has("level") ? $this->getLevel() : $this->getMaxLevel();
            return $this->getConstant()['constants']['upgrade_cost'][--$level];
        }

        public function getUpgradeExp()
        {
            $level = $this->has("level") ? $this->getLevel() : $this->getMaxLevel();
            return $this->getConstant()['constants']['upgrade_exp'][--$level];
        }

        public function getUpgradeStats()
        {
            $stats = [
                "dps"=>false,
                "damage"=>false,
                "death_damage"=>false,
                "hitpoints"=>false,
            ];

            if (!isset($this->getConstant()['stats']) || empty($this->getConstant()['stats'])) return $stats;


            $level = $this->has("level") ? $this->getLevel() : $this->getMaxLevel();
            $constant_stats = collect($this->getConstant()['stats']);
            $plm = $this->getConstant()['constants']["power_level_multiplier"][$level-2];

            if ($constant_stats->has("dps")) {
                $stats['dps'] = $constant_stats->get("dps")*($plm/100);
            }
            if ($constant_stats->has("damage")) {
                $stats['damage'] = $constant_stats->get("damage")*($plm/100);
            }
            if ($constant_stats->has("death_damage")) {
                $stats['death_damage'] = $constant_stats->get("death_damage")*($plm/100);
            }
            if ($constant_stats->has("hitpoints")) {
                $stats['hitpoints'] = $constant_stats->get("hitpoints")*($plm/100);
            }
            return $stats;
        }
    }
