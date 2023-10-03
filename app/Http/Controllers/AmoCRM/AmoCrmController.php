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
        $webHookHandler = new WebhookLeadUpdateService($data);
        $accountId = $webHookHandler->getAccount('id'); 
        $lastRequestTime = json_decode(Storage::get('lastRequestTime.txt'), true);
        $webHookHandler->preventRequestInfiniteLoop($lastRequestTime, $accountId);
        Storage::put('HOOK.txt', json_encode($data));

        $state = (new AmoCRMConfig)->state;
        $requestState = $data['state'];



        /** Аутентификация webhook по state */
        if((int)($requestState) !== (int)$state) {
            response('ok');
            throw new Exception('Неверный state в параметре запроса webhook' . __CLASS__);
            die;
        }

        // self::$webHookHandler = new WebhookLeadUpdateService($data);
        CacheRequestsJob::dispatch(json_encode($data));
       
       
    }


 
}