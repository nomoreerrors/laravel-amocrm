<?php

namespace App\Http\Controllers\AmoCRM;

use App\Models\AmoCRM\AmoCrmConnectionModel;
use Illuminate\Http\Request;
use Resources\Services\WebhookLeadUpdateService;
use AmoCRM\Models\LeadModel;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Exceptions\AmoCRMApiException;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AmoCRM\BaseController;
use App\Http\classes\AmoCRMConfig;
use Illuminate\Support\Facades\Log;


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
    public function getWebHookLeadUpdates(Request $request, AmoCrmConnectionModel $crm)
    {   
         
        $data = $request->except('state');


        $webHookHandler = new WebhookLeadUpdateService($data);
        $accountId = $webHookHandler->getAccount('id'); 
        $lastRequestTime = json_decode(Storage::get('lastRequestTime.txt'), true);


        $webHookHandler->checkRequestLimit($lastRequestTime, $accountId);


        $primeCost = $webHookHandler->getCustomFieldsValues($this->primeCostFieldId)[0]['value']; 
        $price = $webHookHandler->getUpdate('price');
        $updateId = $webHookHandler->getUpdate('id');
        $profit = (int)$price - (int)$primeCost;
        



        // if($lastRequestTime && 
        //    array_key_exists($accountId, $lastRequestTime) &&
        //    $lastRequestTime[$accountId] >= time()) {
        //         Log::info('Остановка цикла запросов. Слишком частые попытки обновить сделку '
        //                                     . $lastRequestTime[$accountId] .' ' . time());
        //         response('ok');
        //         die;
        // }


        

        $crm->connect(new AmoCRMConfig);
        

      

        $leadsService = $crm->apiClient->leads();
        $lead = new LeadModel();
        $leadCustomFieldsValues = new CustomFieldsValuesCollection();
        $textCustomFieldValueModel = new TextCustomFieldValuesModel();
        $textCustomFieldValueModel->setFieldId($this->profitFieldId);
     

      
        $textCustomFieldValueModel->setValues(
            (new TextCustomFieldValueCollection())
                ->add((new TextCustomFieldValueModel())->setValue($profit))
        );
        $leadCustomFieldsValues->add($textCustomFieldValueModel);
        $lead->setCustomFieldsValues($leadCustomFieldsValues);
        $lead->setId($updateId);


        
      


        try {
            $lead = $leadsService->updateOne($lead);
            $lastRequestTime[$accountId] = time() + 3;
            Storage::put('lastRequestTime.txt', json_encode($lastRequestTime));
            Log::info('Запрос к хуку');

        } catch (AmoCRMApiException $e) {
            dd($e);
            die;
        }


         

 
 
       
        
    }
}