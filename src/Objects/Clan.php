<?php
namespace CR\Objects;

/**
 * @method    string              getTag                Returns the tag of the clan
 * @method    string              getName               Returns the name of the clan
 * @method    string              getDescription        Returns the description of the clan
 * @method    string              getType               Returns the admission type of the clan
 * @method    int                 getScore              Returns the score of the clan
 * @method    int                 getMemberCount        Returns the members number of the clan
 * @method    int                 getRequiredScore      Returns the required score to enter the clan
 * @method    int                 getDonations          Returns the total donations per week of the clan
 * @method    ClanChest           getClanChest          Returns the ClanChest object of the clan
 * @method    AllianceBadge       getBadge              Returns the AllianceBadge Object of the clan
 * @method    Location            getLocation           Returns the Location Object of the clan
 * @method    []Player            getMembers            Returns an array with Player Objects of the clan
 *
 * @method    []Player            getPlayers                Alias of getMembers
 * @method    int                 getTotalClanChestCrowns   Get current total crowns of the clan chest
 * @method    int                 getLevelClanChest         Get current level of the clan chest
 */

class Clan extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
          'badge'             => AllianceBadge::class,
          'members'           => Player::class,
          'clanChest'         => ClanChest::class,
        ];
    }


    public function getPlayers()
    {
      return $this->getMembers();
    }

    public function getTotalClanChestCrowns()
    {
      return $this->getMembers()->keyBy('clanChestCrowns')->keys()->sum() ?: 0;
    }


    public function getLevelClanChest()
    {
      $level=0;
      $required=70;
      $total_crowns = $this->getTotalClanChestCrowns();

      while (($total_crowns-$required)>0) {
        $total_crowns -= $required;
        $required+=20;
        $level++;
      }
      return $level;
    }

}
