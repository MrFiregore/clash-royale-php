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
    
    namespace CR\Objects\ConstantsObjects\CardStatsObjects;
    
    use CR\Objects\BaseObject;

    /**
     * Class Spell.
     *
     * @method string      getName()
     * @method string      getRarity()
     * @method int         getLifeDuration()
     * @method int         getLifeDurationIncreasePerLevel()
     * @method int         getLifeDurationIncreaseAfterTournamentCap()
     * @method bool        getAffectsHidden()
     * @method int         getRadius()
     * @method int         getHitSpeed()
     * @method int         getDamage()
     * @method bool        getNoEffectToCrownTowers()
     * @method int         getCrownTowerDamagePercent()
     * @method bool        getHitBiggestTargets()
     * @method string      getBuff()
     * @method int         getBuffTime()
     * @method int         getBuffTimeIncreasePerLevel()
     * @method int         getBuffTimeIncreaseAfterTournamentCap()
     * @method bool        getCapBuffTimeToAreaEffectTime()
     * @method int         getBuffNumber()
     * @method bool        getOnlyEnemies()
     * @method bool        getOnlyOwnTroops()
     * @method bool        getIgnoreBuildings()
     * @method bool        getIgnoreHero()
     * @method null        getProjectile()
     * @method null|string getSpawnCharacter()
     * @method int         getSpawnInterval()
     * @method bool        getSpawnRandomizeSequence()
     * @method null|string getSpawnDeployBaseAnim()
     * @method int         getSpawnTime()
     * @method int         getSpawnCharacterLevelIndex()
     * @method int         getSpawnInitialDelay()
     * @method int         getSpawnMaxCount()
     * @method int         getSpawnMaxRadius()
     * @method int         getSpawnMinRadius()
     * @method bool        getSpawnFromMinToMax()
     * @method int         getSpawnAngleShift()
     * @method bool        getHitsGround()
     * @method bool        getHitsAir()
     * @method string      getKey()
     * @method int         getElixir()
     * @method string      getType()
     * @method int         getArena()
     * @method string      getDescription()
     * @method int         getId()
     */
    class Spell extends BaseObject
    {
        /**
         * {@inheritdoc}
         */
        public function primaryKey ()
        {
            return 'key';
        }
        
        /**
         * {@inheritdoc}
         */
        public function relations ()
        {
            return [];
        }
    }
