<?php
namespace CR\Objects;
use CR\CRConstant;

/**
 *  Card object
 * @method    string              getName()                       Returns the name of the Card.
 * @method    string              getKey()                        Returns the key of the Card.
 * @method    int                 getLevel()                      (Optional) Returns the level of the Card.
 * @method    int                 getMaxLevel()                   Returns the max level of the Card.
 * @method    int                 getCount()                      (Optional) Returns the actual number of the Card.
 * @method    int                 getRequiredForUpgrade()         (Optional) Returns the total required number of cards in this level to upgrade the Card.
 * @method    int                 getLeftToUpgrade()              (Optional) Returns the remaining number of cards in this level to upgrade the Card.
 * @method    string              getIcon()                       Returns the url icon of the Card.
 * @method    int                 getElixir()                     Returns the elixir cost of the Card.
 * @method    string              getType()                       Returns the type of the Card.
 * @method    string              getRarity()                     Returns the rarity type of the Card.
 * @method    int                 getArena()                      Returns the arena level to unlock the Card.
 * @method    int                 getDescription()                Returns the description of the Card.
 * @method    int                 getId()                         Returns the id of the Card.
 *
 * @method    array               getConstant()                   Returns the Card object constants
 * @method    int                 getUpgradeCost()                Returns the cost to upgrade de card
 * @method    int                 getUpgradeExp()                 Returns the remaining experience when upgrade
 * @method    array               getUpgradeStats()               Returns the card stats
 */


class Card extends BaseObject
{
  static protected $constants_stats= null;
  static protected $constants_rarities= null;
  protected $constant = null;
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
        ];
    }
    /**
     * [getConstant description]
     * @method getConstant
     * @return array      Returns an array of Card object constants
     */
    public function getConstant()
    {
      if (is_null(self::$constants_stats)) {
        self::$constants_stats = collect(CRConstant::getConstant("cards_stats"));
      }
      if (is_null(self::$constants_rarities)) {
        self::$constants_rarities = collect(CRConstant::getConstant("rarities"));
      }

      if (is_null($this->constant)) {
        collect(self::$constants_stats->get(strtolower($this->getType())))->map(function ($item,$key)
        {
          if ($item["name_en"]==$this->getName()) {
            $this->constant['stats'] = $item;
          }
        })->all();
        self::$constants_rarities->map(function ($item,$key)
        {
          if ($item["name"]==$this->getRarity()) {
            $this->constant['constants'] = $item;
          }
        })->all();
      }
      return $this->constant;
    }

    public function getUpgradeCost()
    {
      $level = $this->has("level") ? $this->getLevel() : $this->getMaxLevel();
      return $this->getConstant()['constants']['upgrade_exp'][--$level];
    }

    public function getUpgradeExp()
    {
      $level = $this->has("level") ? $this->getLevel() : $this->getMaxLevel();
      return $this->getConstant()['constants']['upgrade_cost'][--$level];
    }
    public function getUpgradeStats()
    {
      $stats = [];
      $level = $this->has("level") ? $this->getLevel() : $this->getMaxLevel();
      $constant_stats = collect($this->getConstant()['stats']);
      $plm = $this->getConstant()['constants']["power_level_multiplier"][$level-2];
      if ($constant_stats->has("dps")) $stats['dps'] = $constant_stats->get("dps")*($plm/100);
      if ($constant_stats->has("damage")) $stats['damage'] = $constant_stats->get("damage")*($plm/100);
      if ($constant_stats->has("death_damage")) $stats['death_damage'] = $constant_stats->get("death_damage")*($plm/100);
      if ($constant_stats->has("hitpoints")) $stats['hitpoints'] = $constant_stats->get("hitpoints")*($plm/100);
      return $stats;
    }

}
