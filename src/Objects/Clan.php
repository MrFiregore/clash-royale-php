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
 * Clan object
 * @method    string              getTag()                    Returns the tag of the clan
 * @method    string              getName()                   Returns the name of the clan
 * @method    string              getDescription()            (Optional) Returns the description of the clan
 * @method    string              getType()                   (Optional)Returns the admission type of the clan
 * @method    int                 getScore()                  (Optional)Returns the score of the clan
 * @method    int                 getMemberCount()            (Optional)Returns the members number of the clan
 * @method    int                 getRequiredScore()          (Optional)Returns the required score to enter the clan
 * @method    string              getRole()                   (Optional).If the Clan object is obtained by a Player object returns the role name of the user
 * @method    int                 getDonations()              Returns the total donations per week of the clan. If the Clan object is obtained by a Player object returns the total donations by the user
 * @method    ClanChest           getClanChest()              (Optional)Returns the ClanChest object of the clan
 * @method    AllianceBadge       getBadge()                  Returns the AllianceBadge Object of the clan
 * @method    Location            getLocation()               (Optional)Returns the Location Object of the clan
 * @method    []Player            getMembers()                (Optional)Returns an array with Player Objects of the clan
 * @method    Tracking            getTracking()               (Optional)Returns a Tracking object of the clan
 *
 * @method    []Player            getPlayers()                (Optional)Alias of getMembers
 * @method    int                 getTotalClanChestCrowns()   (Optional)Get current total crowns of the clan chest
 * @method    int                 getLevelClanChest()         (Optional)Get current level of the clan chest
 */

class Clan extends BaseObject
{
  /**
  * {@inheritdoc}
  */
  public function primaryKey()
  {
      return "tag";
  }


  /**
  * {@inheritdoc}
  */
  public function relations()
  {
    return [
      'badge'             => AllianceBadge::class,
      'members'           => Player::class,
      'clanChest'         => ClanChest::class,
      'location'          => Location::class,
      'tracking'          => Tracking::class,
    ];
  }

  /**
   * Alias of getMembers
   * @method getPlayers
   * @return Player[]
   */

  public function getPlayers()
  {
    return $this->getMembers();
  }
}
