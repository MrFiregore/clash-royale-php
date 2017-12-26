<?php
namespace CR\Objects;

/**
 * [AllianceBadge description]
 *
 *
 * @method    string              getName               Returns the name of the badge
 * @method    string              getCategory           Returns the category name of the badge
 * @method    int                 getId                 Returns the id of the badge
 * @method    string              getImage              Returns the image url of the badge
 *
 *
 */

class AllianceBadge extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }

}
