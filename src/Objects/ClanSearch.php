<?php
namespace CR\Objects;

/**
 * ClanSearch object
 *
 * @method    string              getTag()                Returns the tag of the clan
 * @method    string              getName()               Returns the name of the clan
 * @method    string              getType()               Returns the admission type of the clan
 * @method    int                 getScore()              Returns the score of the clan
 * @method    int                 getMemberCount()        Returns the members number of the clan
 * @method    int                 getRequiredScore()      Returns the required score to enter the clan
 * @method    int                 getDonations()          Returns the total donations per week of the clan
 * @method    AllianceBadge       getBadge()              Returns the AllianceBadge Object of the clan
 * @method    Location            getLocation()           Returns the Location Object of the clan
 */

class ClanSearch extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
          'badge'             => AllianceBadge::class,
          'location'           => Location::class,
        ];
    }
}
