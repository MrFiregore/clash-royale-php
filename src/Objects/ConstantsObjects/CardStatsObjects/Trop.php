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
     * Class Trop.
     *
     * @method string getName()
     * @method string getRarity()
     * @method int    getSightRange()
     * @method int    getDeployTime()
     * @method int    getSpeed()
     * @method int    getHitpoints()
     * @method int    getHitSpeed()
     * @method int    getLoadTime()
     * @method int    getDamage()
     * @method bool   getLoadFirstHit()
     * @method bool   getLoadAfterRetarget()
     * @method bool   getAllTargetsHit()
     * @method int    getRange()
     * @method bool   getAttacksGround()
     * @method bool   getAttacksAir()
     * @method bool   getTargetOnlyBuildings()
     * @method bool   getCrowdEffects()
     * @method bool   getIgnorePushback()
     * @method int    getScale()
     * @method int    getCollisionRadius()
     * @method int    getMass()
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
     * @method bool   getSelfAsAoeCenter()
     * @method bool   getHidesWhenNotAttacking()
     * @method bool   getHideBeforeFirstHit()
     * @method bool   getSpecialAttackWhenHidden()
     * @method bool   getHasRotationOnTimeline()
     * @method bool   getJumpEnabled()
     * @method bool   getRetargetAfterAttack()
     * @method bool   getBurstKeepTarget()
     * @method bool   getBurstAffectAnimation()
     * @method bool   getBuildingTarget()
     * @method bool   getSpawnConstPriority()
     * @method string getNameEn()
     * @method string getKey()
     * @method int    getElixir()
     * @method string getType()
     * @method int    getArena()
     * @method string getDescription()
     * @method int    getId()
     * @method string getSpeedEn()
     * @method float  getDps()
     * @method string getProjectile()
     * @method int    getDeployDelay()
     * @method int    getStopMovementAfterMs()
     * @method int    getWaitMs()
     * @method int    getSightClip()
     * @method int    getSightClipSide()
     * @method int    getWalkingSpeedTweakPercentage()
     * @method int    getFlyingHeight()
     * @method string getDeathSpawnCharacter()
     * @method int    getSpawnStartTime()
     * @method int    getSpawnInterval()
     * @method int    getSpawnNumber()
     * @method int    getSpawnPauseTime()
     * @method int    getSpawnCharacterLevelIndex()
     * @method string getSpawnCharacter()
     * @method int    getDeathDamageRadius()
     * @method int    getDeathDamage()
     * @method int    getDeathPushBack()
     * @method int    getDeathSpawnCount()
     * @method int    getDeathSpawnRadius()
     * @method int    getAreaDamageRadius()
     * @method int    getSpawnRadius()
     * @method int    getChargeRange()
     * @method int    getDamageSpecial()
     * @method string getDamageEffectSpecial()
     * @method int    getChargeSpeedMultiplier()
     * @method int    getJumpHeight()
     * @method int    getJumpSpeed()
     * @method string getCustomFirstProjectile()
     * @method int    getMultipleProjectiles()
     * @method int    getShieldHitpoints()
     * @method int    getCrownTowerDamagePercent()
     * @method int    getSpawnPathfindSpeed()
     * @method int    getAttackPushBack()
     * @method string getProjectileEffectSpecial()
     * @method string getLoadAttackEffect1()
     * @method string getLoadAttackEffect2()
     * @method string getLoadAttackEffect3()
     * @method string getLoadAttackEffectReady()
     * @method int    getRotateAngleSpeed()
     * @method int    getVariableDamage2()
     * @method int    getVariableDamageTime1()
     * @method int    getVariableDamage3()
     * @method int    getVariableDamageTime2()
     * @method string getTargettedDamageEffect1()
     * @method string getTargettedDamageEffect2()
     * @method string getTargettedDamageEffect3()
     * @method string getFlameEffect1()
     * @method string getFlameEffect2()
     * @method string getFlameEffect3()
     * @method int    getTargetEffectY()
     * @method int    getVisualHitSpeed()
     * @method string getSpawnDeployBaseAnim()
     * @method int    getSpawnAngleShift()
     * @method int    getDeathSpawnDeployTime()
     * @method int    getAttackShakeTime()
     * @method int    getMultipleTargets()
     * @method string getBuffOnDamage()
     * @method int    getBuffOnDamageTime()
     * @method string getSpawnAreaObject()
     * @method int    getSpawnAreaObjectLevelIndex()
     * @method int    getDashImmuneToDamageTime()
     * @method int    getDashCooldown()
     * @method int    getDashDamage()
     * @method string getDashFilter()
     * @method int    getDashMinRange()
     * @method int    getDashMaxRange()
     * @method int    getHideTimeMs()
     * @method string getBuffWhenNotAttacking()
     * @method int    getBuffWhenNotAttackingTime()
     * @method string getAttachedCharacter()
     * @method int    getTargetedEffectVisualPushback()
     * @method int    getAttackDashTime()
     * @method string getLoopingFilter()
     * @method int    getLifeTime()
     * @method int    getMorphTime()
     * @method int    getDashPushBack()
     * @method int    getDashRadius()
     * @method int    getDashConstantTime()
     * @method int    getDashLandingTime()
     * @method int    getSpawnLimit()
     * @method int    getSpawnPushback()
     * @method int    getSpawnPushbackRadius()
     * @method int    getKamikazeTime()
     */
    class Trop extends BaseObject
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
