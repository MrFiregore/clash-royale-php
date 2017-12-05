<?php
namespace CR\Objects;



class Clan extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
          // 'badge'             => Badge::class,
          // 'clan'              => Clan::class
        ];
    }
}
