<?php
namespace CR\Objects;
use CR\Objects\Profile;


class Clan extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
          'badge'             => Badge::class,
        ];
    }
    public function getMembers()
    {
      $members = [];
      foreach ($this->get("members") as  $member) {
        $members[] = new Profile($member);
      }
      return $members;
    }
}
