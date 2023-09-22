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
use AmoCRM\Models\CustomFields\CustomFieldModel;
use League\OAuth2\Client\Token\AccessToken;



class AmoAuthController extends Controller
{   

    private $config = [
        'baseDomain' => "gingersnaps.amocrm.ru", 
        'client_id' => 'd6b82438-952d-4558-ae25-9c1588ddbf2c',
        'client_secret' => 'yMhFfxrrtvcIf75564N8QEeH7G3CartHAq8joQYPuFKjyQiSI541uHA2rNdcMVWL',
        'auth_code' => 'def502008f6871f69ce34a52782631f465ea8777595a06e3d525919454f22cab279a4c6024d7021625af56f7dbca0b89efdb181b2d00ef8bca959c252f11cd84f37b108d27393d1074c1830ff0a0f3960b81ff207aa7afaa68b8628a45636fa007b7583f5e2bcf037b851d236b9bfc08aebc1301bdd471e6d7bdb9ddf83d3e502d31cb33a16cd0f05383ddeb29df35fca931f4d90d81cbe5cf2231eee1b3512475c64c18cddfde789dbf9effc3221e1ca448a87f3f448e99fdf856c193946ad7387a66ad1c7c69ac8a3f480d9e54cce3552c34a6a84f0637510c42f29db1b936c5b1cb81bc5a716b733457d8f34efa608d385341ca246a9455c9fd9eee4e8eafac6e572a50a13b9c58acbda699fcad52e8a0ba5a9b33aa57bee0ebb38416985e78150371516544856b33ffb5fccb5663c23b85756fae8af9fb23d0698054a2934992e18b7720e180a01339c79c07b15479a34a8519d1d5837073520669a3e06dc4ea9a100e9b87577bcba118e62f53d819e6d40be0b605a5b68b87be641ef184e99e024adee8d38b39bfb92c6369ee75b09b88b066d91d59190db17e1422ccf0b65b74b896d367109668d81be53c8302241faf6ab9dcdeaba7a583d1de91a2645f10b2386e9c2fbe5f430c5694eb43ea784c29d062d5d6bfd557c88aaac335f1bedd8ae52dcaa1a9d7665a',
        'redirect_uri' => 'http://gingerbw.beget.tech'
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
         
        $connect = new AmoConnectionInitialize($this->config);
        $accessToken = $connect->getAccessToken();
        $oAuthClient = $connect->getOauthClient();


        $lead = new LeadModel();
        $lead->setId(22);
        $leadCustomFieldsValues = new CustomFieldsValuesCollection();
         
        $textCustomFieldValuesModel = new TextCustomFieldValuesModel();
        $textCustomFieldValuesModel->setFieldId(442211);
        $textCustomFieldValuesModel->setValues(
            (new TextCustomFieldValueCollection())
                ->add((new TextCustomFieldValueModel())->setValue('Текст'))
        );
        $leadCustomFieldsValues->add($textCustomFieldValuesModel);
        $lead->setCustomFieldsValues($leadCustomFieldsValues);
        $c = $lead->toArray();


        $apiRequest = new AmoCRMApiRequest($accessToken, $oAuthClient);
        $apiRequest->post('post', $c, [1],  [ 'Content-Type' => 'application/json',
                                                'Authorization: Bearer ' . $accessToken
                                                ]);


        // pprim pprosm ppubm СНИППЕТЫ
        // pif pifel

        // $testData = json_decode(Storage::get('updates.txt'), true);
        // $a = new WebhookRequestHandler($testData);
        // $c = $a->getCustomFieldsValues();
        // dd($c);
       
        
    }
}