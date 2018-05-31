<?php
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 ~                                                                                                                                                                                                                                                          ~
 ~ Copyright (c) 2018 by firegore (https://firegore.es) (git:firegore2)                                                                                                                                                                                     ~
 ~ This file is part of clash-royale-php.                                                                                                                                                                                                                   ~
 ~                                                                                                                                                                                                                                                          ~
 ~ clash-royale-php is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 ~ clash-royale-php is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                                                                  ~
 ~ See the GNU Affero General Public License for more details.                                                                                                                                                                                              ~
 ~ You should have received a copy of the GNU General Public License along with clash-royale-php.                                                                                                                                                           ~
 ~ If not, see <http://www.gnu.org/licenses/> 2018.05.31                                                                                                                                                                                                    ~
 ~                                                                                                                                                                                                                                                          ~
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

namespace CR\Objects;
use CR\Objects\ConstantsObjects\Card;


/**
*  PlayerStats object
* @method    int              getTournamentCardsWon()             Returns total cards won in tournaments.
* @method    int              getMaxTrophies()                    Returns the max player trophies.
* @method    int              getThreeCrownWins()                 Returns total wins with 3 crowns.
* @method    int              getCardsFound()                     Returns total cards found.
* @method    Card             getFavoriteCard()                   Returns statics about the favourite player card.
* @method    int              getTotalDonations()                 Returns total donations.
* @method    int              getChallengeMaxWins()               Returns total challenges wins.
* @method    int              getChallengeCardsWon()              Returns total cards won in challenges.
* @method    int              getLevel()                          Returns the tower level.
*/

class PlayerStats extends BaseObject
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
      "favoriteCard"    => Card::class
    ];
  }

}
