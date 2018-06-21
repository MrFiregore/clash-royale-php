<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
<h1 id="clash-royale-php-packagist-github-release-total-downloads">clash-royale-php
    <a href="https://packagist.org/packages/firegore2/clash-royale-php">
        <img src="https://img.shields.io/packagist/v/firegore2/clash-royale-php.svg" alt="Packagist"/>
    </a>
    <a href="https://github.com/firegore2/clash-royale-php/releases/latest">
        <img src="https://img.shields.io/github/release/firegore2/clash-royale-php.svg" alt="GitHub release"/>
    </a>
    <a href="https://packagist.org/packages/firegore2/clash-royale-php">
        <img src="https://poser.pugx.org/firegore2/clash-royale-php/downloads" alt="Total Downloads"/>
    </a>
</h1>
<p>THE UNOFFICIAL PHP Clash Royale Wrapper</p>
<h1 id="index">INDEX</h1>
<style>
    ol {
    counter-reset: item
}

li {
    display: block
}

li:before {
    content: counters(item, ".") " ";
    counter-increment: item
}
</style>
<ol>
    <li>
        <a href="#info">INFO</a>
    </li>
    <li>
        <a href="#documentation">DOCUMENTATION</a>
    </li>
    <li>
        <a href="#contributing">CONTRIBUTING</a>
    </li>
    <li>
        <a href="#requirements">REQUIREMENTS</a>
    </li>
    <li>
        <a href="#installation">INSTALLATION</a>
    </li>
    <li>
        <a href="#token">TOKEN</a>
    </li>
    <li>
        <a href="#upcoming-features">UPCOMING FEATURES</a>
    </li>
    <li>
        <a href="#methods">METHODS</a>
        <ol>
            <li>
                <a href="#all-methods">ALL METHODS</a>
            </li>
            <li>
                <a href="#getplayer--">getPlayer()</a>
            </li>
            <li>
                <a href="#getclan--">getClan()</a>
            </li>
            <li>
                <a href="#gettop--">getTop()</a>
            </li>
            <li>
                <a href="#clansearch">clanSearch</a>
            </li>
        </ol>
    </li>
</ol>
<h1 id="info">INFO</h1>
<p>This work with the back-end of this page
    <a href="https://royaleapi.com/">Clash Royale API</a>
</p>
<h1 id="documentation">DOCUMENTATION</h1>
<p>All the document can be found in this web
    <a href="https://docs.royaleapi.com/#/">Royale API Docs</a>.
</p>
<p>We will make other specific docs in the wiki section for this wrapper and how it works (
    <em>comming soon</em> )
</p>
<h1 id="contributing">CONTRIBUTING</h1>
<p>You can contribute to this project opening a new issue with your ideas or you can contact with me by
    <a href="https://t.me/firegore">Telegram</a>
</p>
<h1 id="requirements">REQUIREMENTS</h1>
<blockquote>
    <p>PHP 5.6 or greater</p>
</blockquote>
<blockquote>
    <p>Composer</p>
</blockquote>
<h1 id="installation">INSTALLATION</h1>
<p>In the root of your project (the same path wich contain the composer file) enter</p>
<pre>
				<code> composer install </code>
			</pre>
<p>to install the library or use</p>
<pre>
				<code>composer require firegore2/clash-royale-php </code>
			</pre>
<p>to instal in your own project.</p>
<h1 id="token">TOKEN</h1>
<p>You need a developer token to use the API.</p>
<p>This are the steps to obtain it:</p>
<ol>
    <li>Go to the
        <a href="http://discord.me/RoyaleApi">discord server</a> of the API
    </li>
    <li>Go to the #developer-key channel.</li>
    <li>Type
        <code>?crapikey get</code>
    </li>
    <li>The bot will send you a DM (direct message) with your key.</li>
</ol>
<h1 id="upcoming-features">UPCOMING FEATURES</h1>
<blockquote>
    <p>Multi threading</p>
</blockquote>
<blockquote>
    <p>Auto generated documents</p>
</blockquote>
<blockquote>
    <p>Auto generated database (SQL or SQLlite)</p>
</blockquote>
<blockquote>
    <p>Cron</p>
</blockquote>
<h1 id="methods">METHODS</h1>
<blockquote>
    <p>See
        <a href="https://github.com/firegore2/clash-royale-php/tree/master/examples">examples</a> folder for more
        information
    </p>
</blockquote>
<h2 id="all-methods">ALL METHODS</h2>
<pre>
				<code class="php">
                    <?php
                    @method getPlayer([ player0,player1,player2,player3,...],[ Optional keys0,keys1,keys2,keys3,...],[ Optional exclude0,exclude1,exclude2,exclude3,...])
                    @method getPlayerBattle([ player0,player1,player2,player3,...],[ Optional keys0,keys1,keys2,keys3,...],[ Optional exclude0,exclude1,exclude2,exclude3,...])
                    @method getPlayerChest([ player0,player1,player2,player3,...],[ Optional keys0,keys1,keys2,keys3,...],[ Optional exclude0,exclude1,exclude2,exclude3,...])
                    @method getClanSearch( Optional name default = '' , Optional score default = 0 , Optional minMembers default = 0 , Optional maxMembers default = 50 )
                    @method getClanTracking([],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getClan([ clan0,clan1,clan2,clan3,...],[ Optional keys0,keys1,keys2,keys3,...],[ Optional exclude0,exclude1,exclude2,exclude3,...])
                    @method getClanBattle([ clan0,clan1,clan2,clan3,...],[ Optional keys0,keys1,keys2,keys3,...],[ Optional exclude0,exclude1,exclude2,exclude3,...], Optional type default = '' )
                    @method getClanWar([ clan0,clan1,clan2,clan3,...],[ Optional keys0,keys1,keys2,keys3,...],[ Optional exclude0,exclude1,exclude2,exclude3,...])
                    @method getClanWarlog([ clan0,clan1,clan2,clan3,...],[ Optional keys0,keys1,keys2,keys3,...],[ Optional exclude0,exclude1,exclude2,exclude3,...])
                    @method getClanHistory([','','',...],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getClanHistoryWeekly([','','',...],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getClanTracking([','','',...],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getClanTrack([','','',...],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getTournamentOpen([],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getTournamentKnown([],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getTournamentSearch([],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getTournament([','','',...],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getTopClan(['CountryCode'],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getTopPlayer( Optional location default = '' )
                    @method getPopularClan([],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getPopularPlayer([],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getPopularTournament([],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getPopularDeck([],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getConstant()
                    @method getAuthStats()
                    @method getVersion([],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getHealth()
                    @method getStatus([],['includeKey1','includeKey2','includeKey3',...],['excludeKey1','excludeKey2','excludeKey3',...])
                    @method getEndpoints()
                </code>
			</pre>
<h2 id="getplayer">getPlayer()</h2>
<pre>
				<code class="php">
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
                </code>
			</pre>
<h2 id="getclan">getClan()</h2>
<pre>
				<code class="php">
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
                </code>
			</pre>
<h2 id="gettop">getTop()</h2>
<pre>
				<code class="php">
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
                </code>
			</pre>
<h2 id="clansearch">clanSearch</h2>
<pre>
				<code class="php">
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
                </code>
			</pre>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
        integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"
        integrity="sha384-u/bQvRA/1bobcXlcEYpsEdFVK/vJs3+T+nXLsBYJthmdBuavHvAW6UsmqO2Gd/F9"
        crossorigin="anonymous"></script>

</body>
</html>
