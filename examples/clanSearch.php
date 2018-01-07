<?php
ini_set('max_execution_time', 3000);
use CR\Api;
require '../vendor/autoload.php';

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
