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
 ~ If not, see <http://www.gnu.org/licenses/> 2018.06.13                                                                                                                                                                                                    ~
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
    use CR\Objects\ConstantsObjects\Tournament;
    use CR\Objects\ConstantsObjects\TreasureChest;

    /**
     * Constants Object
     * @method AllianceBadge[] getAllianceBadges()
     * @method Arena[] getArenas()
     * @method Card[] getCards()
     * @method CardStats   getCardsStats()
     * @method Challenge[] getChallenges()
     * @method ChestCycle getChestOrder()
     * @deprecated   getClanChest()
     * @method GameMode[] getGameModes()
     * @method Rarity[] getRarities()
     * @method Region[] getRegions()
     * @method Tournament[]  getTournaments()
     * @method TreasureChest getTreasureChests()
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
                'tournaments'       =>  Tournament::class,
                'treasure_chests'   =>  TreasureChest::class,
            ];
        }
    }
