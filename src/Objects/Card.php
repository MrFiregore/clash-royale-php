<?php
namespace CR\Objects;


class Card extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
          'arena'             => Arena::class,
        ];
    }
}
