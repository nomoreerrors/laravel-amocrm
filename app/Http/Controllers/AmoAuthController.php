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
    

    protected function getToken()
    {
        $subdomain = 'gingersnaps'; 
        $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; 
        $data = [
            'client_id' => 'c619beb0-3934-4354-8b73-515ce57573ee',
            'client_secret' => 't2yJpDwDKUd1CaaZoajClNXiIVLNdwdcEWc4WMm6HQZQtcVQBXLP8IAid2GjBHoY',
            'grant_type' => 'authorization_code',
            'code' => 'def50200e3f65a658a9b8b68f9a8032054bef12baa8dc40f1a1d756687f6e64cedac78358ea4352663166b196c718b6885d1dd2b8414ba90e5d4a8bdea6e153d71c88611b3fbaf4db76cb9c5131ca0f1a813d72c3970a7b19f5b9808dfb880816ab6e80dc98362dc4e1049d0c76bf80c13c96656438c1c7072c5a8c3bef8d57f0a32790eb900929d7e3479fedb58eac8ebf7c690bf8f6ce9d94862631724e2d08c061da5dfbf98883fde7e925bc491b798c5e70261fb54c4fbd938ed2d963d3f8868b74c5b415de9148dc6534060e4877e2aaca91dbcb4c315d734269b139072acfbc199f3257af527092f34cac29bfad8e0f46b32e4ec652526f1e8caa8802f5b951b2cf513cfaaabe6a050ab638197ea2ea8e21cc0e9d180b7ac5064e6a3aa2f9cca31548ece48dd15dbc88ae525138942b5ef76498fe70497a88cc2effff8edbdc4df8ce9f0c7ae6432c7bb7eb184630a2ee27f304be48f20f40a9547ba774175c151779e0e9e25b84226821e10945ec0d8266f93590489cb647ad53d91acb489c0096bcc1e136f5856b1524e3b4dae6e6ddab3bfba136781443c620b9db8d4b3e720ecd39a84bc9ddb7135e2703f4204adee7ea56bba5162d299e861e92e5b669b61c7bcbf37758a16bb3cc2abe20b3cb6c75bc51a243e386ca1f206f143fa0587bf6fb1d93a5ddc2f',
            'redirect_uri' => 'http://gingerbw.beget.tech',
        ];

       

        $out = Http::withHeaders([
                        'User-Agent' => 'amoCRM-oAuth-client/1.0',
                        'Content-Type' => 'application/json'
                    ])->post($link, $data);

        $response = json_decode($out, true); //преобразование строки JSON в массив
        $statusCode = (int)$response['status'];
        echo '<h1>SUCCESS</h1>';

        
        $access_token = $response['access_token']; 
        $refresh_token = $response['refresh_token'];  
        $token_type = $response['token_type']; 
        $expires_in = $response['expires_in'];
  

     
    }
}
