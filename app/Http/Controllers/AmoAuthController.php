<?php

namespace App\Http\Controllers;

use AmoCRM\Client\AmoCRMApiRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\EntitiesServices\Webhooks;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use \AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use Illuminate\Support\Facades\Storage;
use App\Http\classes\AmoConnectionInitialize;
use Illuminate\Http\RedirectResponse;
use AmoCRM\Collections\BaseApiCollection;
use AmoCRM\Collections\CustomFields\CustomFieldsCollection;
use AmoCRM\Models\BaseApiModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\CustomFields\CustomFieldModel;

class AmoAuthController extends Controller
{   

    protected string $field;


    /**
     * Аутентификация по коду авторизации и получение access token
     */
    protected function authByCode(): void
    {
        $config = [
        'baseDomain' => "gingersnaps.amocrm.ru", 
        'client_id' => 'd6b82438-952d-4558-ae25-9c1588ddbf2c',
        'client_secret' => 'yMhFfxrrtvcIf75564N8QEeH7G3CartHAq8joQYPuFKjyQiSI541uHA2rNdcMVWL',
        'auth_code' => 'def502004dec37cee30f1fe777a5de488882b4e34ab6f1a34b73de07d312c4d5c092900b55f5127c1af0d3481543d0a4bde4e482dfb64add0e2e42805ed8e874aa936ef25604144c4fdd48dfba8144f76f2a22b8f4c8b3797625ed5b8bc58eee614087a86da51b5c18e8822b87a796aceee7b2e807c9edf67ed107a547867b75a01b7304a82903c395246e444ce09654d6b45d69241e010a2fa27141231b64ed360e79f7be343479ea421ac28695bb8f5345a8bfc3d43e0fd133bbd7e8c0247fdc9acf9fe612337bdf2bf54e6b27d2d32035faa15ddf9efa305e683395d61728d254989623c855bd67568ccef49a0e8b8587a1ebe18504ee6c2196fd450400babacf9e62d4b6ece67dd8d17ca4eda7c983fb01eda5f517aae6eec38350dcd168f1387334291628ba108b12d07fd5cd22c1db34547129b70261d1efd103adb5d37afedd39ad17f67328c152cdc12417d865a1b92f7d38d353879d32387defcc577da5e18db5ba1657c3d5fc90715efc2e51d837b7f8c987e3e7db1eda286dbcb162d6876f929371ed7a06d6ba2ecf39cd31d5d6b1a4f3ac8389610464c511a48f001d9a05c7212cea48da0b8302bbe6b96515f1782c28d4486aad62ec1a6012de11e7303621d3c0f798dd1adf62c9053133c92f1aa4ac7460649ffd46f714637315261b83e4ec5e74b37fb7',
        'redirect_uri' => 'http://gingerbw.beget.tech'
        ];
        
        $connect = new AmoConnectionInitialize($config);

     
    }
    /**
     * Рекурсия возвращает любое поле массива, полученного из webhooks
     */
    public function getField(array $data, string $field): array
    {
                static $a = [];
                static $c = [];
                    foreach($data as $key => $value) {
                        foreach($value as $key2 => $value2) {
                            if($key2 == $field) {
                            $a[$field] = $value2;
                        }
                        if(gettype($value2) == 'array') {
                            $c[$key2] = $value2;
                        };
                        };
                    };
                if(count($a) == 0) {
                    $this->getField($c, $field);
                } 
                //throw exception?
              return $a;
                 
    }
        






    /**
     * Получить новую сделку или изменения в сделке с AmoCRM
     */
    public function getUpdatesByHook(Request $request)
    {
        // $data = $request->all();
        // $account_id = $data['account']['account_id'];
        // $costPrice = $data['leads']['update'][0]['custom_fields'][0]['values']['value'];
        $data = [
            "account" => 
                [
                    "subdomain" => "gingersnaps",
                    "id" => "31285798",
                    "_links" => ["self" => "https => \/\/gingersnaps.amocrm.ru"]
                ],
            "leads" => 
                [
                    "update" => 
                    [
                        [
                            "id" => "38138155",
                            "name" => "\u041f\u043e\u043a\u0443\u043f\u043a\u0430 \u0444\u0443\u0442\u0431\u043e\u043b\u044c\u043d\u044b\u0445 \u043c\u044f\u0447\u0435\u0439",
                            "status_id" => "60307670",
                            "price" => "177000",
                            "responsible_user_id" => "10067946",
                            "last_modified" => "1694964742",
                            "modified_user_id" => "10067946",
                            "created_user_id" => "10067946",
                            "date_create" => "1694964733",
                            "pipeline_id" => "7227930",
                            "account_id" => "31285798",
                            "custom_fields" => 
                            [
                                [
                                "id" => "2129045",
                                "name" => "\u0421\u0435\u0431\u0435\u0441\u0442\u043e\u0438\u043c\u043e\u0441\u0442\u044c",
                                "values" => [["value" => "120000"]]
                                ]
                             ],
                            "created_at" => "1694964733",
                            "updated_at" => "1694964742"
                        ]
                    ]
                ]
            ];

            

  
            
            $result = $this->getField($data, 'value');
            dd($result);
        
        // $data = $request->all();
        // Storage::put('request.txt', json_encode($data));
        

           
       
        // return back();

    }
}
