<?php
/**************************************************************************************************************************************************************************************************************************************************************
 *                                                                                                                                                                                                                                                            *
 * Copyright (c) 2018 by Firegore (https://firegore.es) (git:firegore2).                                                                                                                                                                                      *
 * This file is part of clash-royale-php.                                                                                                                                                                                                                     *
 *                                                                                                                                                                                                                                                            *
 * clash-royale-php is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. *
 * clash-royale-php is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                                                                    *
 * See the GNU Affero General Public License for more details.                                                                                                                                                                                                *
 * You should have received a copy of the GNU General Public License along with clash-royale-php.                                                                                                                                                             *
 * If not, see <http://www.gnu.org/licenses/>.                                                                                                                                                                                                                *
 *                                                                                                                                                                                                                                                            *
 **************************************************************************************************************************************************************************************************************************************************************/

namespace CR;
use CR\CRCache;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use CR\HttpClients\GuzzleHttpClient;


/**
 *
 */
class CRVersion
{
  const API_VERSION = "1.3.1";
  /**
   * @var GuzzleHttpClient HTTP Client
   */
  protected static $httpClientHandler;



  /**
   * Returns the HTTP client handler.
   *
   * @return GuzzleHttpClient
   */
  protected static function getHttpClientHandler()
  {
    if (is_null(self::$httpClientHandler)) {
      $client = new Client();

      self::$httpClientHandler = new GuzzleHttpClient($client);
    }
      return self::$httpClientHandler;
  }
  /**
   * [checkGithub description]
   * @param  string $version [description]
   * @return [type]          [description]
   */
  public static function checkGithub(string $version)
  {

    $rawResponse = self::getHttpClientHandler()->send(
      "https://api.github.com/repos/firegore2/clash-royale-php/releases/tags/".$version,
      "GET",
      [RequestOptions::HEADERS=>["Accept: application/vnd.github.v3+json"]],
      30,
      false,
      60
    );
    return $rawResponse->getStatusCode() == 200 ? $rawResponse->getBody()->getContents() : false;
  }
  /**
   * [checkPackagist description]
   * @return [type] [description]
   */
  public static function checkPackagist()
  {

    $rawResponse = self::getHttpClientHandler()->send(
      "https://packagist.org/p/firegore2/clash-royale-php.json",
      "GET",
      [],
      30,
      false,
      60
    );
    return $rawResponse->getStatusCode() == 200 ? $rawResponse->getBody()->getContents() : false;
  }

  /**
   * [checkVersion description]
   * @return [type] [description]
   */
  public static function checkVersion()
  {
    if (!CRCache::exists("APIVERSION".self::API_VERSION) || version_compare(self::API_VERSION,CRCache::get("APIVERSION".self::API_VERSION),">")) {
      CRUtils::delTree(CRCache::getPath());
      CRCache::write("APIVERSION".self::API_VERSION,self::API_VERSION);
    }

    if (!CRCache::exists("checkVersion", ["maxage"=>60])) {
      CRCache::write("checkVersion","1");
      if ($packagist = self::checkPackagist()) {
        $packagist = collect(json_decode($packagist,true)['packages']['firegore2/clash-royale-php'])
        ->reject(function ($item,$key)
        {
          return $key === "dev-master";
        });
        $max_version = $packagist->max("version");
        if (version_compare($max_version,self::API_VERSION,">")) {
          $new_version = $packagist->get($max_version);
          unset($packagist);
          $alert = "New version ** $max_version ** available of ** ".$new_version['name']." **  - ".$new_version['description']."\n";

          if ($github = self::checkGithub($max_version)) {
            $github = json_decode($github,true);
            $alert .= "###".$github['name']."\n ---\n".$github['body']." \n ---\n";
          }
          $alert .= "Run `composer update firegore2/clash-royale-php` to update the package.\n";
          echo CRUtils::markdownToHTML($alert);
        }
      }
    }


  }



}
