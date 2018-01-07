<?php
namespace CR\Objects;


/**
*  PlayerStats object
* @method    int              getTournamentCardsWon()             Returns total cards won in tournaments.
* @method    int              getMaxTrophies()                    Returns the max player trophies.
* @method    int              getThreeCrownWins()                 Returns total wins with 3 crowns.
* @method    int              getCardsFound()                     Returns total cards found.
* @method    Card             getFavoriteCard()                   Returns statics about the favourite player card.
* @method    int              getTotalDonations()                 Returns total donations.
* @method    int              getChallengeMaxWins()               Returns total challenges wins.
* @method    int              getChallengeCardsWon()              Returns total cards won in challenges.
* @method    int              getLevel()                          Returns the tower level.
*/

class PlayerStats extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
          "favoriteCard"    => Card::class
        ];
    }

}
