<?php
namespace CR\Objects;


/**
 * Player Object
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
 * @method    PlayerGame          getGames()             Returns the PlayerGame Object of the player
 * @method    ChestCycle          getChestCycle()        Returns the ChestCycle Object of the player
 * @method    Card[]              getCurrentDeck()       (Optional) Returns an array of Card objects that contains the current deck
 * @method    Card[]              getCards()             (Optional) Returns an array of Card objects that contains all information about the player cards
 * @method    Battle[]            getBattles()           (Optional) Returns an array of Battle objects that contains all information about the last 24 battles of the player
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
          'stats'             => PlayerStats::class,
          'games'             => PlayerGame::class,
          'battles'           => Battle::class,
        ];
    }
}
