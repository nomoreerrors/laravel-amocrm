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
use stdClass;

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
        // $lastRequestTime = json_decode(Storage::get('lastRequestTime.txt'), true);


       

        $updateData = new stdClass();
        $updateData->primeCost = $webHookHandler->getCustomFieldsValues($this->primeCostFieldId)[0]['value']; 
        $updateData->price = $webHookHandler->getUpdate('price');
        $updateData->updateId = $webHookHandler->getUpdate('id');
        $updateData->profit = (int)$updateData->price - (int)$updateData->primeCost;
        $updateData->profitFieldId = $this->profitFieldId;
        $updateData->accountId = $accountId;

        
        $webHookHandler->updateProfitField($updateData);
        
        
    }
}