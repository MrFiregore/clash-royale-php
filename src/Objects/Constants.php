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
    use CR\Objects\ConstantsObjects\AllianceBadge;
    use CR\Objects\ConstantsObjects\Arena;
    use CR\Objects\ConstantsObjects\Challenge;
    use CR\Objects\ConstantsObjects\ChestCycle;
    use CR\Objects\ConstantsObjects\GameMode;
    use CR\Objects\ConstantsObjects\Card;
    use CR\Objects\ConstantsObjects\Rarity;
    use CR\Objects\ConstantsObjects\Region;

    /**
     * Constants Object
     * @method    string              getTag()               Returns the tag of the player
     * @method    string              getName()              Returns the name of the player
     * @method    int                 getTrophies()          Returns the number of trophies of the player
     * @method    int                 getRank()              Returns the rank in the clan if the Player object is obtained by a Clan object, otherwise return the position of the player in the global rank
     * @method    string              getRole()              (Optional) Returns the clan role name of the player if the Player object is obtained by a Clan object
     * @method    string              getDeckLink()          (Optional) Returns the deck url of the player
     *
     * @method    Arena               getArena()             Returns the Arena Object of the player
     * @method    Clan                getClan()              (Optional) Returns the Clan Object of the player
     * @method    PlayerStats         getStats()             Returns the PlayerStats Object of the player
     * @method    GameMode            getGames()             Returns the PlayerGame Object of the player
     * @method    PlayerChest          getChestCycle()        Returns the PlayerChest Object of the player
     * @method    Card[]              getCurrentDeck()       (Optional) Returns an array of Card objects that contains the current deck
     * @method    Card[]              getCards()             (Optional) Returns an array of Card objects that contains all information about the player cards
     * @method    Battle[]            getBattles()           (Optional) Returns an array of Battle objects that contains all information about the last 24 battles of the player
     */

    class Constants extends BaseObject
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
                'alliance_badges'   => AllianceBadge::class,
                'arenas'            => Arena::class,
                'cards'             => Card::class,
//                'cards_stats'       => Deck::class,
                "challenges"        =>  Challenge::class,
                'chest_order'       =>  ChestCycle::class,
                'game_modes'        =>  GameMode::class,
                'rarities'          =>  Rarity::class,
                'regions'           =>  Region::class,
//                'tournaments'       =>  PlayerChest::class,
//                'treasure_chests'   =>  PlayerChest::class,
            ];
        }
    }
