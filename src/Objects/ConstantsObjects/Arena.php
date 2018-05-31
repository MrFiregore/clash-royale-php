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


    /**
     *  Arena object
     * @method    string              getName()                         Returns the name of the Arena.
     * @method    string              getArena()                        Returns the title of the Arena.
     * @method    int                 getArenaID()                      Returns the id of the Arena.
     * @method    int                 getTrophyLimit()                  Returns the trophyes limit to reach to the arena.
     *
     *
     * @method    array               getMaxDonationCount()             Returns the max donation per card type
     * @method    array               getConstant()                     Returns the Arena object constants
     */
    class Arena extends BaseObject
    {
        protected $constant= null;

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
                // 'arenas'             => Arena::class,

            ];
        }

        /**
         * [getConstant description]
         * @method getConstant
         * @return array      Returns an array of Arena object constants
         */
        public function getConstant()
        {
            if (is_null($this->constant)) {
                collect(CRConstant::getConstant("arenas"))->map(function ($item,$key)
                {
                    if ($item["title"]==$this->getArena()) {
                        $this->constant = $item;
                    }
                })->all();
            }
            return $this->constant;
        }

        /**
         * [getMaxDonationCount description]
         * @method getMaxDonationCount
         * @return array             Returns an associative array with the max donation per card type
         */
        public function getMaxDonationCount()
        {
            $group = collect($this->getConstant())
                ->reject(function ($value,$key)
                {
                    return (strpos($key,"max_donation_count_")===false);
                })
                ->map(function ($item,$key)
                {
                    return [str_replace("max_donation_count_","",$key)=>$item];
                })
                ->mapWithKeys(function ($item)
                {
                    return [key($item)=>$item[key($item)]];
                })->all();

            return $group;
        }

    }
