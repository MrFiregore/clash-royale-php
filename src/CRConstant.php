<?php
namespace CR;
use CR\Exceptions\CRSDKException;


/**
 *
 */
class CRConstant
{
  const BASE_URL = "https://cr-api.github.io/cr-api-data/json/";
  static protected $file_cache = "";
  static protected $endpoint = "";
  static protected $max_cache_age = 3600;

  public function getConstant($endpoint)
  {
    self::$endpoint = $endpoint.".json";
    self::$file_cache= "constant-".$endpoint;
    if (CRCache::exists(self::$file_cache,["maxage"=>self::$max_cache_age])) {
      $response = CRCache::get(self::$file_cache);
    } else {
      if ($response = file_get_contents(self::BASE_URL.self::$endpoint)) {
        CRCache::write(self::$file_cache,$response);
      } else {
        throw new CRSDKException("Error when try request ".self::BASE_URL.self::$endpoint." constants", 1);
      }
    }

    return json_decode($response,true);
  }
}
