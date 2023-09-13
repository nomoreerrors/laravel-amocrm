<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use AmoCRM\Client\AmoCRMApiClient;


class AmoAuthController extends Controller
{

   
    
    protected function getToken()
    {
        $subdomain = "gingersnaps"; 
        $link = "https://" . $subdomain . ".amocrm.ru/oauth2/access_token"; 


        $data = [
            "client_id" => "d7424ba2-7070-4a5b-9124-dcdea55b6197",
            "client_secret" => "RTseKQRdMwe3tH0WO450mwgRT0TvMeyL6A2UjlsOxhzRM7P3eGnCCQVydCsH1GMn",
            "grant_type" => "authorization_code",
            "code" => "def50200eacb359cb21f238691a5ae06861c1c93ac8667351a4d183795418cbb6bf44a917ab584fc0ac24f8ee505af266dd136e6f1ee5935015063d2079ad8b95571f4e9f0d75d3a537230c5b61484293637e67e442a0f2e72102334ee981de7094098ce52618d4c5b52eb830ffde99c4bd814121c22cb6bdd1ce37223dc6e2be723ef7d1385f495a3672d7745d1800fb485d3d86c7c851568265318978d480c4a27de3afe3c86b416ad020bbccff65de75f9606d0f6fdf0dcb63875fcae8de7606ad3d6e05f49848afe57afc0c91f522dbe488d94a812e1f90735a474117b8e27174b34b05ee86d802db7083198c7f31e2486848d0b2ef6ae8b3e90eb44cdeb2e23f3ce032fa93be5324ec005504f97e8aa35a8da8bd47f45994f4392c926ceb85aae87a66ca96faa72d6a37ef357259092568d6ee7a7b990a5b38b6b3d954bb96213166d01c8cfef3cb55c610aeb68095d3b4506c54b7ae70ca151571579dbe7281f8dcb17bd26a6bcf5f29e2215c70019a700852d6c14fbadd38608f0a2e02840af777728d0361669e40653be1fcf47999b5035c80d2186914b812c49d43ff81ec2e591004d34af93508b6406d51380b066cf8769faa697cbb78835a3b25a031f38f210b84e916cc24155d49cc556a09d10c964720bf4039420891895debdaf753e40e6e5b927022cb34449",
            "redirect_uri" => "http://gingerbw.beget.tech"
        ];

        $apiClient = new AmoCRMApiClient($data['client_id'], $data['client_secret'], $data['redirect_uri']);
        $token = $apiClient->getAccessToken();
        dd($token);




        
        // $apiClient = Http::withHeaders([
        //     "content-type" => "application/json",
        //     "User-Agent" => "amoCRM-oAuth-client/1.0",
        // ])->post($link, $data);




     }
}
