<?php
namespace CR\Objects;


/**
 * @method    string              getName               Returns the name of the player
 * @method    Arena               getArena              Returns the Arena Object of the player
 * @method    int                 getRole               Returns the role id of the player
 * @method    string              getRoleName           Returns the role name of the player
 * @method    int                 getexpLevel           Returns the experience level of the player
 * @method    int                 getTrophies           Returns the number of trophies of the player
 * @method    int                 getDonations          Returns the donations number of the player
 * @method    int (Optional)      getCurrentRank        Returns the current clan position in the clan of the player
 * @method    int (Optional)      getPreviousRank       Returns the previous clan position of the player
 * @method    int (Optional)      getClanChestCrowns    Returns the name of the player
 * @method    int                 getScore              Returns the name of the player
 * @method    Clan (Optional)     getScore              Returns the name of the player
 */

class Player extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
          'arena'             => Arena::class,
          'clan'              => Clan::class,
          'cards'             => Card::class,
          'currentDeck'       => Card::class,
        ];
    }
}
