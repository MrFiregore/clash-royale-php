<?php
ini_set('max_execution_time', 3000);
use CR\Api;
require '../vendor/autoload.php';

$token = "YOUR_TOKEN";
$api = new Api($token);

try {
  
  $clan = $api->getClan(["YQ02QJ"]);
  d($clan);

  foreach ($clan->getPlayers() as $player) {
    $name = $player->getName();
    $tag = $player->getTag();
    $arena = $player->getArena();//Arena Object
    $role = $player->getRole();
    $exp_level = $player->getexpLevel();
    $trophies = $player->getTrophies();
    $rank = $player->has("rank") ?  $player->getRank() : false ;
    $previous_rank = $player->has("previousRank") ? $player->getPreviousRank() : false;
    $clan_chest_crowns= $player->getClanChestCrowns();
    $donations = $player->getDonations();
    $donations_received = $player->getDonationsReceived();
    $donations_delta = $player->getDonationsDelta();
    $donations_percent = $player->getDonationsPercent();

    d(
      $player,
      $tag,
      $name,
      $arena,
      $role,
      $exp_level,
      $trophies,
      $rank,
      $previous_rank,
      $clan_chest_crowns,
      $donations,
      $donations_received,
      $donations_delta,
      $donations_percent
    );
  }
} catch (\Exception $e) {
  d($e);
}
