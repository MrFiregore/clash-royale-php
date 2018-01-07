<?php
namespace CR\Objects;

/**
 * Clan object
 * @method    string              getTag()                Returns the tag of the clan
 * @method    string              getName()               Returns the name of the clan
 * @method    string              getDescription()        (Optional) Returns the description of the clan
 * @method    string              getType()               (Optional)Returns the admission type of the clan
 * @method    int                 getScore()              (Optional)Returns the score of the clan
 * @method    int                 getMemberCount()        (Optional)Returns the members number of the clan
 * @method    int                 getRequiredScore()      (Optional)Returns the required score to enter the clan
 * @method    string              getRole()               (Optional).If the Clan object is obtained by a Player object returns the role name of the user
 * @method    int                 getDonations()          Returns the total donations per week of the clan. If the Clan object is obtained by a Player object returns the total donations by the user
 * @method    ClanChest           getClanChest()          (Optional)Returns the ClanChest object of the clan
 * @method    AllianceBadge       getBadge()              Returns the AllianceBadge Object of the clan
 * @method    Location            getLocation()           (Optional)Returns the Location Object of the clan
 * @method    []Player            getMembers()            (Optional)Returns an array with Player Objects of the clan
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
      $c = 0;
      collect($this->getPlayers())->map(function ($item,$key) use (&$c)
      {
        $c += $item->getClanChestCrowns();
      });
      return $c;
    }


    public function getLevelClanChest()
    {
      $level=0;
      $required=70;
      $total_crowns = $this->getTotalClanChestCrowns();

      while (($total_crowns-$required)>=0) {
        $total_crowns -= $required;
        $required+=20;
        $level++;
      }
      return $level;
    }

}
