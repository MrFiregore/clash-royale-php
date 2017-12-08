# clash-royale-php
 [![Packagist](https://img.shields.io/packagist/v/firegore2/clash-royale-php.svg)](https://packagist.org/packages/firegore2/clash-royale-php)

[![GitHub release](https://img.shields.io/github/release/firegore2/clash-royale-php.svg)](https://github.com/firegore2/clash-royale-php/releases/latest)


THE UNOFFICIAL PHP  Clash Royale API

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
to instal in your own project

# METHODS

## getProfiles()

```
<?php
use CR\Api;
require 'vendor/autoload.php';
 /**
 * Return all the information about the given users tags
 * @method getPRofile
 * @param  array     $profile         Array with the tag of the profiles
 * @return array|Profile              Array of Profile Objects if given more than one profile, else return one Profile Object
 */
$api = new Api();
try{
 $profiles = $api->getProfiles(["JSDFS45","ASDAD123"]);
 d($profile); //This display the array with Profile objects
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
$api = new Api();
try{
 $clans = $api->getClan(["clan_tag1","clan_tag2"]);
 d($clans); //This display the Array of Clan objects
}
catch(Exception $e){
 d($e);
}

```

