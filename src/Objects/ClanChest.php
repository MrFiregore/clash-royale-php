<?php
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 ~                                                                                                                                                                                                                                                          ~
 ~ Copyright (c) 2018 by firegore (https://firegore.es) (git:firegore2)                                                                                                                                                                                     ~
 ~ This file is part of clash-royale-php.                                                                                                                                                                                                                   ~
 ~                                                                                                                                                                                                                                                          ~
 ~ clash-royale-php is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 ~ clash-royale-php is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                                                                  ~
 ~ See the GNU Affero General Public License for more details.                                                                                                                                                                                              ~
 ~ You should have received a copy of the GNU General Public License along with clash-royale-php.                                                                                                                                                           ~
 ~ If not, see <http://www.gnu.org/licenses/> 2018.05.31                                                                                                                                                                                                    ~
 ~                                                                                                                                                                                                                                                          ~
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

namespace CR\Objects;

/**
 * ClanChest Object
 * @method    string              getStatus()                         Returns the status of the clan chest ("active","inactive" , "completed")
 * @method    bool                isFinished()                        Returns true if the clan chest has finished or completed, otherwise returns false
 * @method    int                 getMaxLevel()                       Returns the max level of the clan chest
 * @method    int                 getLevel()                          Returns the level of the clan chest
 *
 * @method    int                 getRemainingCrownsNextLevel()       Returns the number of crowns remaining for the next level
 */

class ClanChest extends BaseObject
{
    /**
    * {@inheritdoc}
    */
    public function primaryKey()
    {
        return "";
    }

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
        return in_array($this->getStatus(), ["active","completed"]);
    }


    /**
     * Returns the number of crowns remaining for the next level
     * @method getRemainingCrownsNextLevel
     * @return int                      number of crowns remaining for the next level
     */

    public function getRemainingCrownsNextLevel()
    {
        if ($this->getLevel() == $this->getMaxLevel()) {
            return 0;
        }
        $lvl = 0;
        $c = 0;
        $req_lvl = $this->getLevel()+1;
        $req_c = 70;
        while ($lvl<$req_lvl) {
            $c += $req_c;
            $req_c += 20;
            $lvl++;
        }
        return $c-$this->getCrowns();
    }
}
