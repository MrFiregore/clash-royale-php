# clash-royale-php [![Packagist](https://img.shields.io/packagist/v/firegore2/clash-royale-php.svg)](https://packagist.org/packages/firegore2/clash-royale-php) [![GitHub release](https://img.shields.io/github/release/firegore2/clash-royale-php.svg)](https://github.com/firegore2/clash-royale-php/releases/latest) [![Total Downloads](https://poser.pugx.org/firegore2/clash-royale-php/downloads)](https://packagist.org/packages/firegore2/clash-royale-php)
THE UNOFFICIAL PHP  Clash Royale Wrapper
# INFO

This work with the back-end of this page [Clash Royale API](https://cr-api.com/)

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
1. Go to the [discord server](http://discord.me/cr_api) of the API
2. Go to the #developer-key channel.
3. Type !crapikey get
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
   * @param  array     $player         Array with the id of the profiles
   * @return array|Player              Array of Player Objects if given more than one profile, else return one Player Object
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
* @return array|Clan         Array of Clan Objects if given more than one profile, else return one Clan Object
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
