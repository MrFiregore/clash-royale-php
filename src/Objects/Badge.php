<?php
namespace CR\Objects;
use CR\CRClient;



class Badge extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
    public function getUrl()
    {
      return CRClient::BASE_URL."badge/".$this->get("filename");
    }

}
