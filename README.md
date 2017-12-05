# clash-royale-php
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

$api = new Api();
$profiles = $api->getProfiles(["JSDFS45","ASDAD123"]);
```

