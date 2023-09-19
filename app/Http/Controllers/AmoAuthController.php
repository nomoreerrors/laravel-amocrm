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
        'client_id' => 'd7424ba2-7070-4a5b-9124-dcdea55b6197',
        'client_secret' => 'GIKKv84w9uNqnhO1rUTIbkIkhJhMUxDu62d4CYqBTyuP7gw61idW8iR9Vkw6bg4I',
        'auth_code' => 'def5020077d3f5f9a1d0051f5492396f44ea30b734ed9c5c8b0c93d67fd6891e2382f3e28acd6a384360c07afe97af75e1cf4eb66a65291028e661f01531f72314963432a43f9fbd535dc397cbf4c1876a03d91534c4e6e1132c8b98fd585582582687cb1cae0a2da3bead92509764e1a3775fa28db362fc1cc268080b35bc8e8199db885acba83e83096521211928a74d5d1ca74bc11d58ac290bf7ab46c098e30da6c18ee6e28ff3f58bd224cef1ba79ac16724316c31793986456a53480786f808b4dccd3e3afcffa2b1931264b3db56a2dd2949fb50b3f2ebf898e492c23782ea153cf038296e700f0b041d2b229ab93492e38081781de3a7ef9ee35dbc3af9e61afb76458f8da44a914cdbc0f9df80f048634b343fa3705fc383f71d42098371b11bbc6450c86d053ebead76b2cafe92468537de84e27415d76b9f779d230d4d8f35fe249744c6d409794b300dbce561288951652f31b961609aa83eb4c34a627a7576529a04fd8d7d090f068a869db462a5a4eee478d8d85487fd74666689abaa75a49865b36b90b26844d86cc48d2b45b3b4a2fb1bdc3067c9fda72f2e5c45042807ca7f3f56d6da85ca8ccfe370ba97cc74b85633c85800effd718e5b06f7acc5b3288e41c8f6d35f33ce1bd342fca55e0dfe1b778fce94e8b58f5e52989e9b2af657d2294e9a3',
        'redirect_uri' => 'http://gingerbw.beget.tech'
        ];
        
        AmoConnectionInitialize::apiRequest($config);

     
    }


    public function getField(array $data, string $field): array
    {
    //    $this->field = $field;

    // function (array $item) use ($itemClass) {
    // Попробую убрать вложенность. Из каждого массива сделать отдельный объект и проверять
    // или раскрыть скобки массивов внутри, запушить все в один массив, потом фильтр
    // или просто добраться до элемента массива вручную и получать кастомные окна по названию аргумента

    dd($field);
        

    }
 
       


    /**
     * Получить новую сделку или изменения в сделке с AmoCRM
     */
    public function getUpdatesByHook(Request $request)
    {
        // $data = $request->all();
        // $account_id = $data['account']['account_id'];
        // $costPrice = $data['leads']['update'][0]['custom_fields'][0]['values']['value'];
        // $data = [
        //     "account" => 
        //         [
        //             "subdomain" => "gingersnaps",
        //             "id" => "31285798",
        //             "_links" => ["self" => "https => \/\/gingersnaps.amocrm.ru"]
        //         ],
        //     "leads" => 
        //         [
        //             "update" => 
        //             [
        //                 [
        //                     "id" => "38138155",
        //                     "name" => "\u041f\u043e\u043a\u0443\u043f\u043a\u0430 \u0444\u0443\u0442\u0431\u043e\u043b\u044c\u043d\u044b\u0445 \u043c\u044f\u0447\u0435\u0439",
        //                     "status_id" => "60307670",
        //                     "price" => "177000",
        //                     "responsible_user_id" => "10067946",
        //                     "last_modified" => "1694964742",
        //                     "modified_user_id" => "10067946",
        //                     "created_user_id" => "10067946",
        //                     "date_create" => "1694964733",
        //                     "pipeline_id" => "7227930",
        //                     "account_id" => "31285798",
        //                     "custom_fields" => 
        //                     [
        //                         [
        //                         "id" => "2129045",
        //                         "name" => "\u0421\u0435\u0431\u0435\u0441\u0442\u043e\u0438\u043c\u043e\u0441\u0442\u044c",
        //                         "values" => [["value" => "120000"]]
        //                         ]
        //                      ],
        //                     "created_at" => "1694964733",
        //                     "updated_at" => "1694964742"
        //                 ]
        //             ]
        //         ]
        //     ];

            

  
            
            // $result = $this->getField($data, 'update');
            // dd($result);
        
        $data = $request->all();
        Storage::put('request.txt', json_encode($data));
        

           
       
        // return back();

    }
}
