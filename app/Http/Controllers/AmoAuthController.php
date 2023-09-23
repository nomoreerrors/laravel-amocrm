<?php

namespace App\Http\Controllers;

use App\Http\classes\AccessTokenHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\classes\AmoConnectionInitialize;
use App\Http\Classes\WebhookRequestHandler;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use AmoCRM\Models\CustomFieldsValues\BaseCustomFieldValuesModel;
use stdClass;
use AmoCRM\Models\BaseApiModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\AmoCRMApiRequest;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Models\CustomFields\CustomFieldModel;
use Exception;
use League\OAuth2\Client\Token\AccessToken;



class AmoAuthController extends Controller
{   

    private $config = [
        'baseDomain' => "nomoreerrors.amocrm.ru", 
        'client_id' => '25f51d4a-e345-4696-bb12-7be346232d40',
        'client_secret' => 'DIuW58Sy6OCnoFAoI5mVz89ofy5y8NK6azqRwOwsKv7VC6zRhAuuRbNXYXRWHeC4',
        'auth_code' => 'def502004b05b6046b9f52d541056293a60fecc0393be86261808f327ad10bf930a7445505009e269a5f68f9fe48b7381506371e7b72ed43beaaf483adcc60dcbfa76fd1f1d764124e35c1c63138da0c2d11483495502f97005a0172964aaa5d4a3612ab7b6d868f176762837c1d628a5b99a1f82ef5a4b76f13942d97b5f40771cfc9ed04677cfeae60ea5144638c825626e5f4de2003c6202c7f25e13d199b7ce665c75b68b10c259359c296319b5d0f84bd3952ff851af23a0a334df22e5eadb89815b995a06ac96a12e6acc760f79ab977661e9f0c214fb83b84584d5d44841b43aa5557562092a47fc76c7a2820faf7683bcb3759a373eec02090f7946772f7e2dfd2c5903ed5f1510ec62ee6f2cbcfe793989c40232cf1294317228a165fd43b3536bf7f006ee4003b85272e22fb920981cc66a79a0bf55fb8b2d8890b2efbc69cb39d1add21958c8d1b671b49022bbb9c0388bbef35c660a41df85f86425b9d46e3ff84293bd980548b56b6be4980317ef552818c7918cf6f1a77de83694952f88658704364eb9e6cb5d518416ac6efb264997889a6fb15c5e6848f53fb8386d6f3438c25a361fcf154b74f09157f8a60c17758f44e46a7d4ad81222b46b42ef0213e3a849f8fc81e0b0250a43b8779c4fa94a0fea1930e279db2fa2dd30eb239c17bbed984f092',
        'redirect_uri' => 'http://gingerbw.beget.tech',
        'state' => '08269884f9a9a4b8a7c166da58bdd6a3'
        ];


    /**
     * Аутентификация по коду авторизации и получение access token
     */
    protected function authByCode(): void
    {
        $connect = new AmoConnectionInitialize($this->config);
    }
  


    /**
     * Получить новую сделку или изменения в сделке с AmoCRM
     */
    public function getWebHookUpdates(Request $request)
    {   
        $state = $request->state;

        if((int)($state) !== (int)($this->config['state'])) {
            throw new Exception('Ошибка авторизации state вэбхука');
            die;
        }
        Storage::put('auth_success.txt');

        $connect = new AmoConnectionInitialize($this->config);


        $leadsService = $connect->apiClient->leads();
        $lead = new LeadModel();
        $leadCustomFieldsValues = new CustomFieldsValuesCollection();
        $textCustomFieldValueModel = new TextCustomFieldValuesModel();
        $textCustomFieldValueModel->setFieldId(2505835);
        $textCustomFieldValueModel->setValues(
            (new TextCustomFieldValueCollection())
                ->add((new TextCustomFieldValueModel())->setValue(40000))
        );
        $leadCustomFieldsValues->add($textCustomFieldValueModel);
        $lead->setCustomFieldsValues($leadCustomFieldsValues);
        $lead->setName('Example');
        dd($lead);
        try {
            $lead = $leadsService->addOne($lead);
        } catch (AmoCRMApiException $e) {
            dd($e);
            die;
        }


         

 

        // $testData = json_decode(Storage::get('updates.txt'), true);
        // $a = new WebhookRequestHandler($testData);
        // $c = $a->getCustomFields(21292045);
        // dd($c);
       
        
    }
}