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

 /**
  *
  */
 trait RulesTrait
 {
   /** @var int $last_request  Time of the last request in microseconds */
   protected $last_request = 0;

   /** @var int $limit_count  Total requests per microseconds before flood  */
   protected $limit_count = 2;

   /** @var int $limit_time  Time limit in microseconds before flood  */
   protected $limit_time = 1000000;


   public function waitRequest()
   {
     $remaining =  $this->getFreqLimit() - $this->getElapsedTime();
     if ($remaining > 0) usleep($remaining);
     return $this;

   }

   public function getFreqLimit()
   {
     return $this->limit_time / $this->limit_count;
   }

   public function getElapsedTime()
   {
     return microtime(true)-$this->getLastRequest();
   }
   public function setLastRequest()
   {
     $this->last_request = microtime(true);
     return $this;
   }

   public function getLastRequest()
   {
     return $this->last_request;
   }
 }
