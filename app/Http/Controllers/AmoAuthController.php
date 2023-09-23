<?php

namespace App\Http\Controllers;

use App\Http\classes\AccessTokenHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\classes\AmoConnectionInitialize;
use App\Http\Classes\WebhookRequestHandler;
use Illuminate\Support\Facades\Storage;
use AmoCRM\Models\LeadModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
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
        'client_secret' => 'eH1ULgHUSEi9oi94fhn4MI8qrhQOba1zxYijQQAS01q6TpM8I3n9jeAz3ar1yMfc',
        'auth_code' => 'def502005751799cfcbf2182050206f200da6c5d483135fa5d1e0ddfbf16546b358ad8cf069114c655c63fb0f01ab4f93d23d03d87586df0ef3ec7d69544f08f453c5e8177a9fce3ad70f04f6cdf1d3089640ab53913607ff25cac9ede9545fafd62d88bb542b3e841b824b9620874070fe490c81c0d9c251151bf63adf8d198bcf5e065670ebe8cd8ea98018bdfee1397ca452c992c348025dbd2a68ee7f7282c1789e7fd18ec8d3271726550283110172fa84334a55a8de80360a701fa4ed28a2511307c5d1b89c8868c836f62c245e82b1e4cc2b7bbcd0aefed911abeaa5f914788f3315e8f82644b0e3eb94b016a23b2382c91ad2bd6423a576ca032ae839b1277e4f5e0a6b8d7e25eb48cda8490085eca0555f71b531c155846241033ac9e96ee808308ae063a7ffbb80d6d20df2af8355b0dd5a28274f469d463effcbf7a17949dd820a89f7dd1e6a750d7bc2d8ace87c6e5a713ba976597138128f36f812fd6a52ed600762d810a90f2c32ababd4ac758f203f0678be73623b8dffd24c05b5dfb4d99f18dd917529430ac7cb44c951f0ee56a03e49988658b25f2c01fdd2a11c90333744eb7c1d413af3910c3975ebab8617dbc551259ad8499512c9c96d45c48f23a8d0aee9f6979e2ef2507de01bfd49ab18a3d80db70ac74df98eb9e280afed771f10b1a37e4',
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
     * Получить новую или измененную сделку с webhook AmoCRM
     */
    public function getWebHookUpdates(Request $request)
    {   
       
        $state = $request->state;

        if((int)($state) !== (int)($this->config['state'])) {
            throw new Exception('Неверный state в параметре запроса webhook');
        }
        
       //пробуем изменить сделку и читаем логи на сервере

        $connect = new AmoConnectionInitialize($this->config);


        $leadsService = $connect->apiClient->leads();
        $lead = new LeadModel();
        $lead->setId(38725615);
        $leadCustomFieldsValues = new CustomFieldsValuesCollection();
        $textCustomFieldValueModel = new TextCustomFieldValuesModel();
        $textCustomFieldValueModel->setFieldId(2505835);
        $textCustomFieldValueModel->setValues(
            (new TextCustomFieldValueCollection())
                ->add((new TextCustomFieldValueModel())->setValue(477000))
        );
        $leadCustomFieldsValues->add($textCustomFieldValueModel);
        $lead->setCustomFieldsValues($leadCustomFieldsValues);
        $lead->setName('Покупка огурцов');


        try {
            $lead = $leadsService->updateOne($lead);
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