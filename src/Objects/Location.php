<?php
namespace CR\Objects;

/**
 *  Location object
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

class Location extends BaseObject
{
  static protected $list= null;
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }



    protected function getList()
    {
      if (is_null(self::$list)) {
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
