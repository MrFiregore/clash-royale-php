<?php
namespace CR\Objects;

/**
 * @method    string              getStatus       Returns the status of the clan chest ("inactive" , "completed")
 * @method    int | false         getCrowns       Returns the total clan crowns of the clan
 */

class ClanChest extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
