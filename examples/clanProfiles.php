<?php
ini_set('max_execution_time', 3000);
use CR\Api;
require '../vendor/autoload.php';
$api = new Api();

foreach ($api->getClan(["YQ02QJ"])->getMembers() as $profile) {
  $name = $profile->getName();
  $arena = $profile->getArena();//Arena Object
  $role = $profile->getRole();
  $role_name = $profile->getRoleName();
  $exp_level = $profile->getexpLevel();
  $trophies = $profile->getTrophies();
  $donations = $profile->getDonations();
  $current_rank = $profile->has("currentRank") ?  $profile->getCurrentRank() : false ;
  $previous_rank = $profile->has("previousRank") ? $profile->getPreviousRank() : false;
  $clan_chest_crowns= $profile->getClanChestCrowns();
  $score = $profile->getScore();
  d(
    $name,
    $arena,
    $role,
    $role_name,
    $exp_level,
    $trophies,
    $donations,
    $current_rank,
    $previous_rank,
    $clan_chest_crowns,
    $score
  );
}
