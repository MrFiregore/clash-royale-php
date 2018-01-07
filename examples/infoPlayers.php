<?php
ini_set('max_execution_time', 3000);
use CR\Api;
require '../vendor/autoload.php';

$token = "YOUR_TOKEN";
$api = new Api($token,600);


try {
  $players  = $api->getPlayer(["9UQJCVJ","28Y2082V9"]);
  foreach ($players as $player) {
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
     * @method    PlayerGame         getGames()             Returns the PlayerGame Object of the player
     * @method    ChestCycle          getChestCycle()        Returns the ChestCycle Object of the player
     * @method    Card[]             getCurrentDeck()       (Optional) Returns an array of Card objects that contains the current deck
     * @method    Card[]             getCards()             (Optional) Returns an array of Card objects that contains all information about the player cards
     * @method    Battle[]            getBattles()           (Optional) Returns an array of Battle objects that contains all information about the last 24 battles of the player
     */
    $tag = $player->getTag();
    $name = $player->getName();
    $trophies = $player->getTrophies();
    $rank = $player->getRank();
    $role = $player->getRole();
    $deckLink = $player->getDeckLink();


    echo "<br><b>PLAYER INFO </b><br>";
    d(
      $tag,
      $name,
      $trophies,
      $rank,
      $role,
      $deckLink
    );



    /**
    *  Arena object
    * @method    string              getName()                         Returns the name of the Arena.
    * @method    string              getArena()                        Returns the title of the Arena.
    * @method    int                 getArenaID()                      Returns the id of the Arena.
    * @method    int                 getTrophyLimit()                  Returns the trophyes limit to reach to the arena.
    *
    *
    * @method    array               getMaxDonationCount()             Returns the max donation per card type
    * @method    array               getConstant()                     Returns the Arena object constants
    */
    $arena = $player->getArena();
      $arenaName = $arena->getName();
      $arenaTitle = $arena->getArena();
      $arenaArenaID = $arena->getArenaID();
      $arenaTrophyLimit = $arena->getTrophyLimit();
      $arenaMaxDonationCount = $arena->getMaxDonationCount();
      echo "<br><b>PLAYER ARENA INFO </b><br>";
      d(
        $arenaName,
        $arenaTitle,
        $arenaArenaID,
        $arenaTrophyLimit,
        $arenaMaxDonationCount
      );

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
    $clan = $player->getClan();
      $clanTag        =  $clan->getTag();
      $clanName       =     $clan->getName();
      $clanRole       =     $clan->getRole();
      $clanDonations  =     $clan->getDonations();
      echo "<br><b>PLAYER CLAN INFO </b><br>";
      d(
        $clanTag,
        $clanName,
        $clanRole,
        $clanDonations
      );

      /**
       * AlianceBadge object
       *
       *
       * @method    int                 getId()                 Returns the id of the badge
       * @method    string              getName()               Returns the name of the badge
       * @method    string              getCategory()           Returns the category name of the badge
       * @method    string              getImage()              Returns the image url of the badge
       */
      $clanBadge      =     $clan->getBadge();
        $clanBadgeId        = $clanBadge->getId();
        $clanBadgeName      = $clanBadge->getName();
        $clanBadgeCategory  = $clanBadge->getCategory();
        $clanBadgeImage     = $clanBadge->getImage();
      echo "<br><b>PLAYER CLAN BADGE INFO </b><br>";
      d(
        $clanBadgeId,
        $clanBadgeName,
        $clanBadgeCategory,
        $clanBadgeImage
      );


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
    $stats = $player->getStats();
      $tournamentCardsWon = $stats->getTournamentCardsWon();
      $maxTrophies = $stats->getMaxTrophies();
      $threeCrownWins = $stats->getThreeCrownWins();
      $cardsFound = $stats->getCardsFound();
      $totalDonations = $stats->getTotalDonations();
      $challengeMaxWins = $stats->getChallengeMaxWins();
      $challengeCardsWon = $stats->getChallengeCardsWon();
      $level = $stats->getLevel();
      echo "<br><b>PLAYER STATS </b><br>";
      d(
        $tournamentCardsWon,
        $maxTrophies,
        $threeCrownWins,
        $cardsFound,
        $totalDonations,
        $challengeMaxWins,
        $challengeCardsWon,
        $level
      );
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
      $favoriteCard = $stats->getFavoriteCard();
        $favoriteCardName = $favoriteCard->getName();
        $favoriteCardKey = $favoriteCard->getKey();
        $favoriteCardLevel = $favoriteCard->getLevel();
        $favoriteCardMaxLevel = $favoriteCard->getMaxLevel();
        $favoriteCardCount = $favoriteCard->getCount();
        $favoriteCardRequiredForUpgrade = $favoriteCard->getRequiredForUpgrade();
        $favoriteCardLeftToUpgrade = $favoriteCard->getLeftToUpgrade();
        $favoriteCardIcon = $favoriteCard->getIcon();
        $favoriteCardElixir = $favoriteCard->getElixir();
        $favoriteCardType = $favoriteCard->getType();
        $favoriteCardRarity = $favoriteCard->getRarity();
        $favoriteCardArena = $favoriteCard->getArena();
        $favoriteCardDescription = $favoriteCard->getDescription();
        $favoriteCardId = $favoriteCard->getId();
        $favoriteCardUpgradeExp = $favoriteCard->getUpgradeExp();
        $favoriteCardUpgradeCost = $favoriteCard->getUpgradeCost();
        $favoriteCardUpgradeStats = $favoriteCard->getUpgradeStats();

    echo "<br><b>PLAYER FAVORITE CARD </b><br>";
    d(
      $favoriteCardName,
      $favoriteCardKey,
      $favoriteCardLevel,
      $favoriteCardMaxLevel,
      $favoriteCardCount,
      $favoriteCardRequiredForUpgrade,
      $favoriteCardLeftToUpgrade,
      $favoriteCardIcon,
      $favoriteCardElixir,
      $favoriteCardType,
      $favoriteCardRarity,
      $favoriteCardArena,
      $favoriteCardDescription,
      $favoriteCardId,
      $favoriteCardUpgradeExp,
      $favoriteCardUpgradeCost,
      $favoriteCardUpgradeStats
    );



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
    echo "<br><b>PLAYER DECK INFO </b><br>";

    foreach ($player->getCurrentDeck() as $card) {
      d(
        $card->getId(),
        $card->getName(),
        $card->getKey(),
        $card->getLevel(),
        $card->getMaxLevel(),
        $card->getCount(),
        $card->getRequiredForUpgrade(),
        $card->getLeftToUpgrade(),
        $card->getIcon(),
        $card->getElixir(),
        $card->getType(),
        $card->getRarity(),
        $card->getArena(),
        $card->getDescription(),
        $card->getUpgradeCost(),
        $card->getUpgradeExp(),
        $card->getUpgradeStats()
      );
    }
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
    echo "<br><b>PLAYER CARDS INFO </b><br>";

    foreach ($player->getCards() as $key => $card) {
      d(
        $key,
        $card->getId(),
        $card->getName(),
        $card->getKey(),
        $card->getLevel(),
        $card->getMaxLevel(),
        $card->getCount(),
        $card->getRequiredForUpgrade(),
        $card->getLeftToUpgrade(),
        $card->getIcon(),
        $card->getElixir(),
        $card->getType(),
        $card->getRarity(),
        $card->getArena(),
        $card->getDescription(),
        $card->getUpgradeCost(),
        $card->getUpgradeExp(),
        $card->getUpgradeStats()
      );
    }
    echo "<br><b>=====================================================================</b><br><br><br><br>";

  }
} catch (\Exception $e) {
  d($e);
}
