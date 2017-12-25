<?php
ini_set('max_execution_time', 3000);
use CR\Api;
require '../vendor/autoload.php';
$api = new Api();
try {
  $clan = $api->getClan(["YQ02QJ"]);
  foreach ($clan->getMembers() as $profile) {
    $name = $profile->getName();
    $tag = $profile->getTag();
    $arena = $profile->getArena();//Arena Object
    $role = $profile->getRole();
    $exp_level = $profile->getexpLevel();
    $trophies = $profile->getTrophies();
    $rank = $profile->has("rank") ?  $profile->getRank() : false ;
    $previous_rank = $profile->has("previousRank") ? $profile->getPreviousRank() : false;
    $clan_chest_crowns= $profile->getClanChestCrowns();
    $score = $profile->getScore();
    $donations = $profile->getDonations();
    $donations_received = $profile->getDonationsReceived();
    $donations_delta = $profile->getDonationsDelta();
    $donations_percent = $profile->getDonationsPercent();

    d(
      $profile,
      $tag,
      $name,
      $arena,
      $role,
      $exp_level,
      $trophies,
      $rank,
      $previous_rank,
      $clan_chest_crowns,
      $score,
      $donations,
      $donations_received,
      $donations_delta,
      $donations_percent
    );
  }
} catch (\Exception $e) {
  d($e);
}
