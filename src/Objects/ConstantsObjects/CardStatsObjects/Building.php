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
     * Class Building.
     *
     * @method string getName()
     * @method string getRarity()
     * @method int    getSightRange()
     * @method int    getHitpoints()
     * @method int    getHitSpeed()
     * @method int    getLoadTime()
     * @method bool   getLoadFirstHit()
     * @method bool   getLoadAfterRetarget()
     * @method string getProjectile()
     * @method bool   getAllTargetsHit()
     * @method int    getRange()
     * @method bool   getAttacksGround()
     * @method bool   getAttacksAir()
     * @method bool   getTargetOnlyBuildings()
     * @method int    getAttachedCharacterHeight()
     * @method bool   getCrowdEffects()
     * @method bool   getIgnorePushback()
     * @method int    getScale()
     * @method int    getCollisionRadius()
     * @method int    getTileSizeOverride()
     * @method bool   getShowHealthNumber()
     * @method bool   getFlyDirectPaths()
     * @method bool   getFlyFromGround()
     * @method bool   getHealOnMorph()
     * @method bool   getMorphKeepTarget()
     * @method bool   getDestroyAtLimit()
     * @method bool   getDeathSpawnPushback()
     * @method bool   getDeathInheritIgnoreList()
     * @method bool   getKamikaze()
     * @method int    getProjectileStartRadius()
     * @method int    getProjectileStartZ()
     * @method bool   getDontStopMoveAnim()
     * @method bool   getIsSummonerTower()
     * @method int    getNoDeploySizeW()
     * @method int    getNoDeploySizeH()
     * @method bool   getSelfAsAoeCenter()
     * @method bool   getHidesWhenNotAttacking()
     * @method bool   getHideBeforeFirstHit()
     * @method bool   getSpecialAttackWhenHidden()
     * @method bool   getHasRotationOnTimeline()
     * @method int    getTurretMovement()
     * @method int    getProjectileYOffset()
     * @method bool   getJumpEnabled()
     * @method bool   getRetargetAfterAttack()
     * @method bool   getBurstKeepTarget()
     * @method bool   getBurstAffectAnimation()
     * @method bool   getBuildingTarget()
     * @method bool   getSpawnConstPriority()
     * @method string getNameEn()
     * @method string getAttachedCharacter()
     * @method int    getDeployTime()
     * @method int    getLifeTime()
     * @method string getKey()
     * @method int    getElixir()
     * @method string getType()
     * @method int    getArena()
     * @method string getDescription()
     * @method int    getId()
     * @method int    getSpawnNumber()
     * @method int    getSpawnPauseTime()
     * @method int    getSpawnCharacterLevelIndex()
     * @method string getSpawnCharacter()
     * @method int    getMinimumRange()
     * @method int    getDamage()
     * @method int    getVariableDamage2()
     * @method int    getVariableDamageTime1()
     * @method int    getVariableDamage3()
     * @method int    getVariableDamageTime2()
     * @method string getTargettedDamageEffect1()
     * @method string getTargettedDamageEffect2()
     * @method string getTargettedDamageEffect3()
     * @method string getDamageLevelTransitionEffect12()
     * @method string getDamageLevelTransitionEffect23()
     * @method string getFlameEffect1()
     * @method string getFlameEffect2()
     * @method string getFlameEffect3()
     * @method int    getTargetEffectY()
     * @method int    getSpawnInterval()
     * @method int    getHideTimeMs()
     * @method int    getUpTimeMs()
     * @method int    getManaCollectAmount()
     * @method int    getManaGenerateTimeMs()
     * @method int    getDeathSpawnCount()
     * @method string getDeathSpawnCharacter()
     * @method int    getDeathDamageRadius()
     * @method int    getDeathDamage()
     * @method int    getDeathPushBack()
     * @method int    getDeathSpawnRadius()
     * @method int    getDeathSpawnMinRadius()
     * @method int    getDeathSpawnDeployTime()
     */
    class Building extends BaseObject
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
