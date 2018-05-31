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
    use Illuminate\Support\Collection;

    /**
     *  Region object
     * @method    string              getName()               Returns the name of the location.
     * @method    bool                getIsCountry()          Returns true if the location is a country. otherwise returns false.
     * @method    string              getCode()               Returns the country/continent code
     *
     *
     * @method    string              getContinent()          Returns the continent name
     * @method    string              getContinentCod()       Returns the continent code
     * @method    string              getCountry()            Returns the country name
     * @method    string              getCountryCode()        Returns the country code
     */

    class Region extends BaseObject
    {
        /**
         * List of countrys, continents and her codes
         * @var [type]
         */
        static protected $list= null;

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


        /**
         * [getList description]
         * @method getList
         * @return Collection
         */

        public function getList()
        {
            if (is_null(self::$list)) {
                d((realpath(__DIR__).DIRECTORY_SEPARATOR."CountryCodes.json"));
                self::$list = collect(json_decode(file_get_contents(realpath(__DIR__).DIRECTORY_SEPARATOR."CountryCodes.json"),true));
            }
            return self::$list;
        }



        public function getContinent()
        {
            $list = $this->getList();
            if (!$this->getIsCountry()) return $this->getName();
            $continent = $list->search(function ($item,$key)
            {
                return $item["country_code"]==$this->getCode();
            });
            return ($continent) ? $list->get($continent)["continent"] : "unknow";
        }



        public function getCountry()
        {
            $list = $this->getList();
            if ($this->getIsCountry()) return $this->getName();
            $country = $list->search(function ($item,$key)
            {
                return $item["country_code"]==$this->getCode();
            });
            return ($country) ? $list->get($country)["country"] : "unknow";
        }



        public function getContinentCode()
        {
            $list = $this->getList();
            if (!$this->getIsCountry()) return $this->getCode();
            $continent = $list->search(function ($item,$key)
            {
                return $item["country_code"]==$this->getCode();
            });
            return ($continent) ? $list->get($continent)["continent_code"] : "unknow";
        }



        public function getCountryCode()
        {
            $list = $this->getList();
            if ($this->getIsCountry()) return $this->getCode();
            $country = $list->search(function ($item,$key)
            {
                return $item["country_code"]==$this->getCode();
            });
            return ($country) ? $list->get($country)["country_code"] : "unknow";
        }

    }
