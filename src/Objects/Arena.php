<?php
namespace CR\Objects;
use CR\CRConstant;


/**
*  Arena object
* @method    string              getName()                         Returns the name of the Arena.
* @method    string              getArena()                        Returns the title of the Arena.
* @method    int                 getArenaID()                      Returns the id of the Arena.
* @method    int                 getTrophyLimit()                  Returns the trophyes limit to reach to the arena.
*
*
* @method    array               getMaxDonationCount()             Returns the max donation per card type
* @method    array               getConstant()                     Returns the Arena object constants
*/
class Arena extends BaseObject
{
  protected $constant= null;
  /**
  * {@inheritdoc}
  */
  public function relations()
  {
    return [
      // 'arenas'             => Arena::class,

    ];
  }

  /**
   * [getConstant description]
   * @method getConstant
   * @return array      Returns an array of Arena object constants
   */
  public function getConstant()
  {
    if (is_null($this->constant)) {
      collect(CRConstant::getConstant("arenas"))->map(function ($item,$key)
      {
        if ($item["title"]==$this->getArena()) {
          $this->constant = $item;
        }
      })->all();
    }
    return $this->constant;
  }

  /**
   * [getMaxDonationCount description]
   * @method getMaxDonationCount
   * @return array             Returns an associative array with the max donation per card type
   */
  public function getMaxDonationCount()
  {
    $group = collect($this->getConstant())
    ->reject(function ($value,$key)
    {
      return (strpos($key,"max_donation_count_")===false);
    })
    ->map(function ($item,$key)
    {
      return [str_replace("max_donation_count_","",$key)=>$item];
    })
    ->mapWithKeys(function ($item)
    {
      return [key($item)=>$item[key($item)]];
    })->all();

    return $group;
  }

}
