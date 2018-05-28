# clash-royale-php [![Packagist](https://img.shields.io/packagist/v/firegore2/clash-royale-php.svg)](https://packagist.org/packages/firegore2/clash-royale-php) [![GitHub release](https://img.shields.io/github/release/firegore2/clash-royale-php.svg)](https://github.com/firegore2/clash-royale-php/releases/latest) [![Total Downloads](https://poser.pugx.org/firegore2/clash-royale-php/downloads)](https://packagist.org/packages/firegore2/clash-royale-php)
THE UNOFFICIAL PHP  Clash Royale Wrapper
# INFO

This work with the back-end of this page [Clash Royale API](https://royaleapi.com/)

# REQUIREMENTS

> PHP 5.5 or greater

> Composer

# INSTALLATION
In the root of your project (the same path wich contain the composer file) enter
```
 composer update
```
to install the library or use 
```
composer require firegore2/clash-royale-php
```
to instal in your own project.

# TOKEN
You need a developer token to use the API.

This are the steps to obtain it:
1. Go to the [discord server](http://discord.me/RoyaleApi) of the API
2. Go to the #developer-key channel.
3. Type ```?crapikey get```
4. The bot will send you a DM (direct message) with your key.

# METHODS
> See [examples](https://github.com/firegore2/clash-royale-php/tree/master/examples) folder for more information
## getPlayer()

```
<?php
use CR\Api;
require 'vendor/autoload.php';
   /**
   * Return all the information about the given users tag
   * @method getPlayer
   * @param  array     $player          Array with the id of the profiles
   * @param  array     $keys            Array with the exact parameters to request
   * @param  array     $exclude         Array with the exact parameters to exclude in the request
   * @return Player[]                   Array of Player Objects if given more than one profile, else return one Player Object
   */
$token = "YOUR_TOKEN";
$api = new Api($token);
try{
 $player = $api->getPlayer(["JSDFS45","ASDAD123"]);
 d($player); //This display the array with Player objects
}
catch(Exception $e){
 d($e);
}

```

## getClan()

```
<?php
use CR\Api;
require 'vendor/autoload.php';
/**
 * Return all the information about the given clan tag
 * @method getClan
 * @param  array  $clan       Array with the tag of the clans
 * @return Clan[]         Array of Clan Objects if given more than one profile, else return one Clan Object
 */
$token = "YOUR_TOKEN";
$api = new Api($token);
try{
 $clans = $api->getClan(["clan_tag1","clan_tag2"]);
 d($clans); //This display the Array of Clan objects
}
catch(Exception $e){
 d($e);
}

```
## getTop()
```
<?php
use CR\Api;
require 'vendor/autoload.php';

/**
 * Return all information about the top players or clans
 * @method getTop
 * @param  array  $top  Array with values "players" or/and "clans"
 * @return array        Array with key of respectives top type ("players" or "clans") and with their values an array with "lastUpdate" 
 * of the top list and the respective array with the respective objects type ("players" = array CR\Objects\Profile)
 */

$token = "YOUR_TOKEN";
$api = new Api($token);
try{
 $tops = $api->getTop(["players","clans"]);
 d($tops); //This display the array with Profile objects
}
catch(Exception $e){
 d($e);
}

```

## clanSearch
```
<?php
ini_set('max_execution_time', 3000);
use CR\Api;
require 'vendor/autoload.php';

$token = "YOUR_TOKEN";
$api = new Api($token);

try {
  
  /**
   * Search clans by their attributes
   * @method clanSearch
   * @param  string           $name                 (Optional)Clan name text search.
   * @param  int              $score                (Optional) Minimum clan score.
   * @param  int              $minMembers           (Optional) Minimum number of members. 0-50
   * @param  int              $maxMembers           (Optional) Maximum number of members. 0-50
   * @return ClanSearch[]     $clanSearch           Returns an array of Clan objects that match the search parameters
   */

  $clansSearch = $api->clanSearch("INFRAMUNDO",35140,44,46);

  foreach ($clansSearch as $clanSearch) {

    /**
     * ClanSearch object
     *
     * @method    string              getTag()                Returns the tag of the clan
     * @method    string              getName()               Returns the name of the clan
     * @method    string              getType()               Returns the admission type of the clan
     * @method    int                 getScore()              Returns the score of the clan
     * @method    int                 getMemberCount()        Returns the members number of the clan
     * @method    int                 getRequiredScore()      Returns the required score to enter the clan
     * @method    int                 getDonations()          Returns the total donations per week of the clan
     * @method    AllianceBadge       getBadge()              Returns the AllianceBadge Object of the clan
     * @method    Location            getLocation()           Returns the Location Object of the clan
     */
    $tag = $clanSearch->getTag();
    $name = $clanSearch->getName();
    $type = $clanSearch->getType();
    $score = $clanSearch->getScore();
    $memberCount = $clanSearch->getMemberCount();
    $requiredScore = $clanSearch->getRequiredScore();
    $donations = $clanSearch->getDonations();

    /**
     * AlianceBadge object
     *
     *
     * @method    string              getName()               Returns the name of the badge
     * @method    string              getCategory()           Returns the category name of the badge
     * @method    int                 getId()                 Returns the id of the badge
     * @method    string              getImage()              Returns the image url of the badge
     *
     *
     */
    $badge = $clanSearch->getBadge();
    $name = $badge->getName();
    $category = $badge->getCategory();
    $id = $badge->getId();
    $image = $badge->getImage();


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
    $location = $clanSearch->getLocation();
    $country = $location->getCountry();
    $continent = $location->getContinent();
    $countryCode = $location->getCountryCode();
    $continentCode = $location->getContinentCode();

    d(
      $clanSearch,
      $tag,
      $name,
      $type,
      $score,
      $memberCount,
      $requiredScore,
      $donations,
      $badge,
      $name,
      $category,
      $id,
      $image,
      $location,
      $country,
      $continent,
      $countryCode,
      $continentCode
    );
  }
} catch (\Exception $e) {
  d($e);
}

```
