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

 namespace CR\Traits;

use CR\CRCache;

 /**
  *
  */
 trait CacheTrait
 {
   protected $params;
   protected $base_file;
   protected $extension;
   protected $end_point;

   public function checkCache($end_point,&$params,$querys)
   {
     $this->setEndPoint($end_point);
     $this->setParams($params);
     $this->setBaseFile();
     $this->setExtension($querys);

     $response = [];


     if ($this->needParams() || ($this->optParams() && !empty($this->getParams()))) {
         foreach ($this->getParams() as $key => $value) {
             $file_cache = $this->getBaseFile().$value.".".$this->getExtension();
             $condition = ($this->ping()) ? ["maxage"=>$this->max_cache_age] : [];
             if (CRCache::exists($file_cache, $condition)) {
                 $response[] = json_decode(CRCache::get($file_cache), true);
                 unset($this->params[$key]);
             }
         }
     } else {
         $file_cache = $this->getBaseFile().".".$this->getExtension();
         $condition = ($this->ping()) ? ["maxage"=>$this->max_cache_age] : [];
         if (CRCache::exists($file_cache, $condition)) {
             $response[] = json_decode(CRCache::get($file_cache), true);
             unset($this->params[$key]);
         }
     }
     $this->setParams(array_values($this->getParams()));
     $params = $this->getParams();
     return $response;
   }
   public function saveCache($content,&$response)
   {
     if (empty($this->getParams()) || count($this->getParams()) == 1) {
         $file_cache = $this->getBaseFile().(!empty($this->getParams()) ? $this->getParams()[0] : "").".".$this->getExtension();
         $response[] = $content;
         CRCache::write($file_cache, json_encode($content));
     }
     else {
         foreach ($content as $key => $resp) {
             $response[] = $resp;
             $file_cache = $this->getBaseFile().(isset($this->getParams()[$key]) ? $this->getParams()[$key] : "").".".$this->getExtension();
             CRCache::write($file_cache, json_encode($resp));
         }
     }
   }



   public function setExtension($querys)
   {
     $this->extension = md5(json_encode($querys));
     return $this;
   }
   public function setParams($params)
   {
     $this->params = array_filter($params, function ($var) {
         return !is_null($var);
     });
     return $this;
   }

   public function setEndPoint($end_point)
   {
     $this->end_point = $end_point;
     return $this;
   }

   public function setBaseFile()
   {
     $base_file = preg_replace('/\/?:(tag|cc)\/?|(?<!^)\//m', "-", substr($this->getEndPoint(), 1));
     $this->base_file = (substr($base_file, -1) !== "-") ? $base_file."-" : $base_file;
     return $this;
   }

   /**
   * @return mixed
   */
  public function getParams()
  {
    return $this->params;
  }

  /**
   * @return mixed
   */
  public function getBaseFile()
  {
    return $this->base_file;
  }

  /**
   * @return mixed
   */
  public function getExtension()
  {
    return $this->extension;
  }

  /**
   * @return mixed
   */
  public function getEndPoint()
  {
    return $this->end_point;
  }

   public function needParams()
   {
       return strpos($this->getEndPoint(), ":tag") !== false;
   }

   public function optParams()
   {
       return strpos($this->getEndPoint(), ":cc") !== false;
   }
   abstract public function ping();

 }
