<?php
namespace CR\Objects;


class Battle extends BaseObject
{
    static protected $stats = null;
    static protected $list  = null;

    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
          // 'arena'             => Arena::class,
        ];
    }

}
