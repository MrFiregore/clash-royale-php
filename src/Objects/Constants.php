<?php
namespace CR\Objects;
use CR\Objects\Arena;

class Constants extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
          'arenas'             => Arena::class,

        ];
    }
}
