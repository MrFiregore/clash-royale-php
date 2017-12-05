<?php
namespace CR\Objects;



class Profile extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
          // 'arena'             => Arena::class,
          'clan'              => Clan::class
        ];
    }
}
