<?php

namespace App\Http\Controllers\AmoCRM;

use AmoCRM\Models\LeadModel;
use App\Models\AmoCRM\AmoCrmConnectionModel;
use Illuminate\Http\Request;
use Resources\Services\WebhookLeadUpdateService;
use App\Http\Controllers\AmoCRM\BaseController;
use App\Http\classes\AmoCRMConfig;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Storage;
use Resources\Factories\LeadsFactory;
use App\Jobs\CacheRequestsJob;

class AmoCrmController extends BaseController
{   

    /**
     * id поля "Себестоимость" (value). 
     * @var int costPriceId
     */
    private $primeCostFieldId = 2505835;

    /**
     * id поля "Прибыль"
     * @var int $profitId
     */
    private $profitFieldId = 2505837;

    

    


    /**
     * Аутентификация по коду авторизации и получение access token
     */
    protected function authByCode(AmoCrmConnectionModel $crm, AmoCRMConfig $config): void
    {
        $crm->connect($config);
    }
  



    /**
     * Обработка входящих данных с webhook
     */
    protected function getWebHookLeadUpdates(Request $request)
    {   
        $data = $request->all();
        Storage::append('HOOK.txt', json_encode($data));


        $webHookHandler = new WebhookLeadUpdateService($data);
        $lastRequestTime = json_decode(Storage::get('lastRequestTime.txt'), true);
        $lastLeadId = $webHookHandler->getKeyFromLeads('id'); 


        $accountId = $webHookHandler->getAccount('id'); 
        $state = (new AmoCRMConfig)->state;
        $requestState = $data['state'];



        $webHookHandler->checkState($state, $requestState)
                        ->preventRequestInfiniteLoop($lastRequestTime, $accountId, $lastLeadId);


        $price = $webHookHandler->getKeyFromLeads('price');
        $primeCost = $webHookHandler->getCustomFieldValue($this->primeCostFieldId); 

        if(!$price || !$primeCost) {
            info('Поле бюджет или себестоимость не заполнено');
            response('ok');
            die;
        }


       
        

      
        dd('here');
  
        CacheRequestsJob::dispatch(json_encode($data));
       
       
    }


 
}