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

namespace CR\Objects;

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

class ClanSearch extends BaseObject
{
  /**
  * {@inheritdoc}
  */
  public function primaryKey()
  {
      return "";
  }

  /**
  * {@inheritdoc}
  */
  public function relations()
  {
    return [
      'badge'             => AllianceBadge::class,
      'location'           => Location::class,
    ];
  }
}
