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
     * Class Building
     *
     * @method string getName()
     * @method string getRarity()
     * @method integer getSightRange()
     * @method integer getHitpoints()
     * @method integer getHitSpeed()
     * @method integer getLoadTime()
     * @method boolean getLoadFirstHit()
     * @method boolean getLoadAfterRetarget()
     * @method string getProjectile()
     * @method boolean getAllTargetsHit()
     * @method integer getRange()
     * @method boolean getAttacksGround()
     * @method boolean getAttacksAir()
     * @method boolean getTargetOnlyBuildings()
     * @method integer getAttachedCharacterHeight()
     * @method boolean getCrowdEffects()
     * @method boolean getIgnorePushback()
     * @method integer getScale()
     * @method integer getCollisionRadius()
     * @method integer getTileSizeOverride()
     * @method boolean getShowHealthNumber()
     * @method boolean getFlyDirectPaths()
     * @method boolean getFlyFromGround()
     * @method boolean getHealOnMorph()
     * @method boolean getMorphKeepTarget()
     * @method boolean getDestroyAtLimit()
     * @method boolean getDeathSpawnPushback()
     * @method boolean getDeathInheritIgnoreList()
     * @method boolean getKamikaze()
     * @method integer getProjectileStartRadius()
     * @method integer getProjectileStartZ()
     * @method boolean getDontStopMoveAnim()
     * @method boolean getIsSummonerTower()
     * @method integer getNoDeploySizeW()
     * @method integer getNoDeploySizeH()
     * @method boolean getSelfAsAoeCenter()
     * @method boolean getHidesWhenNotAttacking()
     * @method boolean getHideBeforeFirstHit()
     * @method boolean getSpecialAttackWhenHidden()
     * @method boolean getHasRotationOnTimeline()
     * @method integer getTurretMovement()
     * @method integer getProjectileYOffset()
     * @method boolean getJumpEnabled()
     * @method boolean getRetargetAfterAttack()
     * @method boolean getBurstKeepTarget()
     * @method boolean getBurstAffectAnimation()
     * @method boolean getBuildingTarget()
     * @method boolean getSpawnConstPriority()
     * @method string getNameEn()
     * @method string getAttachedCharacter()
     * @method integer getDeployTime()
     * @method integer getLifeTime()
     * @method string getKey()
     * @method integer getElixir()
     * @method string getType()
     * @method integer getArena()
     * @method string getDescription()
     * @method integer getId()
     * @method integer getSpawnNumber()
     * @method integer getSpawnPauseTime()
     * @method integer getSpawnCharacterLevelIndex()
     * @method string getSpawnCharacter()
     * @method integer getMinimumRange()
     * @method integer getDamage()
     * @method integer getVariableDamage2()
     * @method integer getVariableDamageTime1()
     * @method integer getVariableDamage3()
     * @method integer getVariableDamageTime2()
     * @method string getTargettedDamageEffect1()
     * @method string getTargettedDamageEffect2()
     * @method string getTargettedDamageEffect3()
     * @method string getDamageLevelTransitionEffect12()
     * @method string getDamageLevelTransitionEffect23()
     * @method string getFlameEffect1()
     * @method string getFlameEffect2()
     * @method string getFlameEffect3()
     * @method integer getTargetEffectY()
     * @method integer getSpawnInterval()
     * @method integer getHideTimeMs()
     * @method integer getUpTimeMs()
     * @method integer getManaCollectAmount()
     * @method integer getManaGenerateTimeMs()
     * @method integer getDeathSpawnCount()
     * @method string getDeathSpawnCharacter()
     * @method integer getDeathDamageRadius()
     * @method integer getDeathDamage()
     * @method integer getDeathPushBack()
     * @method integer getDeathSpawnRadius()
     * @method integer getDeathSpawnMinRadius()
     * @method integer getDeathSpawnDeployTime()
     * @package CR\Objects\ConstantsObjects
     */
    class Building extends BaseObject
    {
        /**
         * {@inheritdoc}
         */
        public function primaryKey ()
        {
            return "key";
        }

        /**
         * {@inheritdoc}
         */
        public function relations ()
        {
            return [];
        }
    }
