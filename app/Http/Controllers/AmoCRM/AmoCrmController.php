<?php

namespace App\Http\Controllers\AmoCRM;

use App\Models\AmoCRM\AmoCrmConnectionModel;
use Illuminate\Http\Request;
use App\Http\Classes\WebhookRequestHandler;
use AmoCRM\Models\LeadModel;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Exceptions\AmoCRMApiException;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AmoCRM\BaseController;
use Illuminate\Support\Facades\Log;


class AmoCrmController extends BaseController
{   

    private $config = [
        'baseDomain' => "nomoreerrors.amocrm.ru", 
        'client_id' => '25f51d4a-e345-4696-bb12-7be346232d40',
        'client_secret' => 'eH1ULgHUSEi9oi94fhn4MI8qrhQOba1zxYijQQAS01q6TpM8I3n9jeAz3ar1yMfc',
        'auth_code' => 'def50200ad487cc0b9053ec133b32cd7db87dc88051197f375728a3dc529fe5960bf8dedb93f967894f237eed778f7623d5cb4c4ce3886980fda1f957ee28e4226720df15e261f6da36a4addc0d0f9479104d8b021e397fc7af18f9d863e084c71d475b6b4545e68d00934b492b10ec48560c30027f768254799e16644c4f29f2c3419a0271fba1cb9805963d1e6cb1f5ed942894e533f9f480356d0843e9f80aabc6e270cde8f25c224ef7ac57faeea3964f2b012a177547cf301536ccb95df516a3d98f6ee983f311dbd06aad8c2fa33bf677fc989e8fcb582a29d99311495a1337b215be647f7933b1bccdc92cfa9369102aa91c322ef9f7f863e300c96db4719b7049fc748472c78659420a71716dcfcfb3c5919ea2b563cd8630938ad0eff20e369900a23fd40fc00a5f87454c50cc32a0174ce1244212ee537572d8a04b19f5261e531101663f861127bdeba47c1390de630a6f88c73b665998543dff2d4b0e999c258ea73ca617a847f862b993b5f3e620f6c70c83f2fc329ffa046daf86e446e2ccf93430fb803d75034df2cccfbb37035f1f6daa164c914af4d19ecc89fd90be81051a5cb317c2a121557d7e297c016b2aa4336248221bb9f8906aaa343d0d7d9b4467049ee0c6ab0a30cd4131db4ef6c9df550b08d40167ac681506f4acffa5499dc23e3e1be',
        'redirect_uri' => 'http://gingerbw.beget.tech',
        'state' => '08269884f9a9a4b8a7c166da58bdd6a3'
        ];
    
    /**
     * id поля "Себестоимость" (value). 
     * @var int costPriceId
     */
    private const primeCostId = 2129045;

    /**
     * id поля "Прибыль"
     * @var int $profit
     */
    private const profit = 2505837;

    


    /**
     * Аутентификация по коду авторизации и получение access token
     */
    protected function authByCode(AmoCrmConnectionModel $crm): void
    {
        $crm->connect($this->config);
    }
  


    /**
     * Обработка входящих данных с webhook
     */
    public function getWebHookUpdates(Request $request, AmoCrmConnectionModel $crm)
    {   
        Log::info($request->all());

        $state = $request->state;

        // if((int)($state) !== (int)($this->config['state'])) {
        //     throw new Exception('Неверный state в параметре запроса webhook');
        // }
        
        // $testData = json_decode(Storage::get('updates.txt'), true);
        // $data = $request->except('state');
        // $crm->connect($this->config);
        // $webHookHandler = new WebhookRequestHandler($data);
        // // $c = $webHookHandler->getCustomFieldsValue(self::primeCostId);
        // // $fieldId = $webHookHandler->getUpdate();
        // // dd($fieldId);
        // $price = $webHookHandler->getUpdate(38324215, 'price');
        // $id = $webHookHandler->getAccount('id');
        // dd($price);


      
        //можно настроить отправку данных с хука себе на почту 
        //обновляем поля сделки






        // $leadsService = $crm->apiClient->leads();
        // $lead = new LeadModel();
        // $lead->setId($id);
        // $leadCustomFieldsValues = new CustomFieldsValuesCollection();
        // $textCustomFieldValueModel = new TextCustomFieldValuesModel();
        // $textCustomFieldValueModel->setFieldId(self::profit);
        // $textCustomFieldValueModel->setValues(
        //     (new TextCustomFieldValueCollection())
        //         ->add((new TextCustomFieldValueModel())->setValue(477000))
        // );
        // $leadCustomFieldsValues->add($textCustomFieldValueModel);
        // $lead->setCustomFieldsValues($leadCustomFieldsValues);
        // $lead->setName('Покупка огурцов');


        // try {
        //     $lead = $leadsService->updateOne($lead);
        // } catch (AmoCRMApiException $e) {
        //     dd($e);
        //     die;
        // }


         

 

        // $testData = json_decode(Storage::get('updates.txt'), true);
        // $a = new WebhookRequestHandler($testData);
        // $c = $a->getCustomFields(21292045);
        // dd($c);
       
        
    }
}