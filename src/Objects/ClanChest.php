<?php
namespace CR\Objects;

/**
 * ClanChest Object
 * @method    string              getStatus()       Returns the status of the clan chest ("active","inactive" , "completed")
 * @method    bool                isFinished()      Returns true if the clan chest has finished or completed, otherwise returns false
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

    /**
     * Check if the clan chest has finished
     * @method isFinished
     * @return bool    Returns true if the clan chest has finished or completed, otherwise returns false
     */
    public function isFinished()
    {
      return in_array($this->getStatus(),["active","completed"]);
    }
}
