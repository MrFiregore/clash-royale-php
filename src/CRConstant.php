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
use CR\Exceptions\CRSDKException;


/**
 *
 */
class CRConstant
{
  const BASE_URL = "https://github.com/RoyaleAPI/cr-api-data";
  static protected $file_cache = "";
  static protected $max_cache_age = 3600;

  public static function getConstant($endpoint)
  {
    $url = str_replace('{endpoint}',$endpoint,self::BASE_URL);
    self::$file_cache= "constant-".$endpoint;
    if (CRCache::exists(self::$file_cache,["maxage"=>self::$max_cache_age])) {
      $response = CRCache::get(self::$file_cache);
    } else {
      if ($response = file_get_contents($url)) {
        CRCache::write(self::$file_cache,$response);
      } else {
        throw new CRSDKException("Error when try request ".$url." constants", 1);
      }
    }

    return json_decode($response,true);
  }
}
