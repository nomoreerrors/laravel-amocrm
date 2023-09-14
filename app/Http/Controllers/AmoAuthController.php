<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use AmoCRM\Client\AmoCRMApiClient;
use Carbon\Exceptions\Exception;
use Spatie\FlareClient\Api;


class AmoAuthController extends Controller
{
    
    protected function getSponsor(Request $request)
    {
      echo 'Im here!!!!!!!';
    }


    protected function getToken()
    {
        $client_id = 'c619beb0-3934-4354-8b73-515ce57573ee';
        $client_secret = 'i0DDmNODe146gokSR8gc2vRVkfhLneiBSjEYlM9Qxoyg92W7PeKiSlIEPD1CmKyH';
        $redirect_uri = 'http://gingerbw.beget.tech';
        $autorization_code = 'def502005f88192b1184d553ffdb13b3d865be9787006fb25253e942f177482a8a2f7b4373bb5f6a953ca168a3ce83c65fe61cc6f341246818fdd55fc24c4843292893a7486f787ab3fea5811919121960ab53d578411caa0b0eed9449f0839a1ee3c162648621413219f34d61b0d536db8997346cdfb77b926ca353188d3712ff9696a7e505ec364b641f0f62224de0d9aacc690bd4e34689432fc1f17d5a62dea8acb6616efb874fb3d4fecbaa61aceca23c13a2bf98b7f7115f14b7fed0b79ae27f02167766615f3ba4b9ea81898be70642cc845281916385a0ea9a053c9c8c2d8993afaab55f96f713bf5910b39d0b813d220b554d67011cc4934eb067a55be7ee7519d81f7896ac8484974c8c294efa6f5128c542f2953b629192ddd5872d1b46a705425ef9ccd3a32cacff0dc674d664d67f9e9a6dd66523f57d8866f03fa9dd7e939cb27ee32911f73449fb83a6f60ff7ca2f24476bb18354fcfdd1e9cb27af0a2fd92bf7dc0dd33e3452e94d3b1a65738fd4e2b98fb5e20f5a9d777af553850e6365952ab948918db5c3e9cc0d2fde30e9bb3cf7cd8c2688ba3a7a835ba24b4a949b932f936d3e0db16318a7f98a0eab8e4820c6dc876de43f25577053a25768d6a43bd511ff51e987609ae0444f45690647c199710b509668e1145b8dc06896fe4147dcd0f51c';
        $state = bin2hex(random_bytes(16));
        http://gingerbw.beget.tech/?code=def502009358c351c456b8c3e8bf79b1969d36f7f251068b1b31ab5781d1bb9d6c5b533fc3cc5a23e90ae39b51e988d8b9c23f0d6fcd995d866012eff5b95c6010d98391d72ec4ff05384c7b5174825a6bf57be092644381e30f5a2c0e25af2d240b3aaeb2321325ba4f5634cd409aba8ff190fe6f9956e8e30b0709cabb3b3574567946e5562b445b2c5c6da8246c7c49f797a4f84f5606a9cc73d939d2b2e824d3a1a9910be15b48a31f70314722e88e914b9611eef31b2215231f8f8c6b941dc464a5471234135a9e671da9c63d6990e658aa4bdd1fe3efea2013602809eb050cd4f38d87cc61d65b37c60673c6e3de7c6cf29a8517e0790d021d0dbab87f028133825d1bfe9d5d180228252c21d8040b8661ff43588a182158a978dcccc3620e8e6156e07c274e9220ffc080f0b39de7420fc4b24ab16af4552eecf13dc4e674e7dae06cc0ecee4f6f58d56d417096d3f8abedc2fa62ee7be14b200a6ee912eaee555f160237c5400417bde1a8b774b394c38bb86e4ddb973e4bdca0944cd88dd8262aef08bb7a4cef124460deb1516ad0dd6e141c9778bc1c420f0aa3b60a523f8f0ae2841176c2371559b896ca1f68da41f1e19c9aef03e935e2789c1bf0549da07068086bb9a7f6c9604edde27d34fb9382481e69ec6467be029aa3dd54421c3450b9abb70e7b63&state=18a261e70b30ae837eb2c55e91a486ea&referer=gingersnaps.amocrm.ru&platform=1&client_id=c619beb0-3934-4354-8b73-515ce57573ee
         

        

        $apiClient = new AmoCRMApiClient($client_id, $client_secret, $redirect_uri);

        
        $subdomain = 'gingersnaps'; 
        $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; 


        $data = [
            'client_id' => 'c619beb0-3934-4354-8b73-515ce57573ee',
            'client_secret' => '5OWp4jw9Y4qvnGPZ3IzJbY6PDD2KoxgNM6c5FmFHK2G1hGDpwfogTW4uryPq0MGU',
            'grant_type' => 'authorization_code',
            'code' => 'def50200b059873de08cfe4f381d76f460bc6c60e2777ae4b0e466127e3820a4acd7682a19e421769b222aa3c496ce778f479453577c8f0e3a24168714ffe75f682d9020fd609f4aa7772aeba3cf404ca4b21075ca05e44d6435f36ed6719d65cd9f472190df51401e8306bf4f522d1e531173b4215b9aab7554da5d18f61828f60c394f21f2f593dc46e0195199116d300100d8302da56ed747a3068e19f1ccac269863bceec15141d30fc152d30f9a3e0d7f9aa140fc62624277e4affdc301a68089e399103e57caa4dea928f77de59fea969b3c153133c38ee510b297c90fd93a4081af59f811b1f9dbbb4b62fae731d0d990b5ea213dfc026c2fadd62436e19341496955eb341adea3d5ecfe19275fec35072d722a194b86a81ee766b7d15f261a4d2a87bdcae7257b23672cf14d94631e907dd88e84db8f5adbd393bb5de401ba2527f797c8f557c62bb5dfc5ab22c4b30cf6d4e69502e0f6b5e501c3d07f4fccca717f1798d005a8b330ec4e13d8cd70f62f2ca116442a78da01e3464f1e1b4a1c33c42fad190fe57887af74ae50d6f362a598b88a911cd4a74520da2719749be2f43a8782afc2d1c5d11c8040eb9500288e6407178f22e2c9a9d6e1fec1d37b57ee55cc712bf1e1141465a0d305e00fb431a099927f0f70b7512bca1e94536191a94cbd292c0994',
            'redirect_uri' => 'http://gingerbw.beget.tech',
        ];

       
    
        $curl = curl_init(); 
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);  
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);


        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try
        {
            if ($code < 200 || $code > 204) {
                echo "ошибочка";
                // throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        }
        catch(\Exception $e)
        {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        /**
         * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
         * нам придётся перевести ответ в формат, понятный PHP
         */
        dd($out);
        $response = json_decode($out, true);

        $access_token = $response['access_token']; 
        $refresh_token = $response['refresh_token'];  
        $token_type = $response['token_type']; 
        $expires_in = $response['expires_in'];
        
        


    }
}
