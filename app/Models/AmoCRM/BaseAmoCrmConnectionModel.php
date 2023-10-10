<?php

namespace App\Models\AmoCRM;

use App\Models\CrmConnectionInterface;


class BaseAmoCrmConnectionModel implements CrmConnectionInterface
{

      /** @var AmoCRMApiClient */
      public $apiClient;

      protected $oAuthClient;
      
      protected $accessToken;
  

      
    public function connect(object $config)
    {
       
    }
}
