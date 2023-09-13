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
            "client_secret" => "pX2z7hawERQNVRhqQ4EbW8AWvP9uLowN96cjB7Z2SugWPPZe5jORLQU8EIK95GF1",
            "grant_type" => "authorization_code",
            "code" => "def502008b43da7e7230ffa8bf0d85973152a04040e294c1e149a78eb876fb58c839271b0d50f1cbce66914ec87aa0e5bd9446b284d8a296ed87691cc4098d6a82e1087964fa28e9c55f632c3456d74523ec5130dad88942e065b084477493b1596b350a75b8b8672b10fbf5f72f1ff9e31c29c01441279a4d4f29a7c85cee23548719536d8a161ae5f8726e2ea35016b92666fe165259978322ca1b8f2997266d436b244fd31d1b0f60e56dae4286bc40918cd4309b75711f3e8d5f89e26ee8a34059d9b1efc2eb16e3dbe0cb2c1f1993acfb968135974b24e7c096e5a64cb0eebe5bdf13639aceddffe535cf335ce2fefc29f73c975c492d53c159f26328f4251acc8d3170bd9468926fd6271f2880042f3514c09b158b91ca5452464242b6acdfc5ac073ae2c8990948ef47402fa2859994ce595c0d94be8c0586dc2017f7697c40e3f3b0ff5e127e060016c932ae836e16310106f64580ad909883e587cff4279db2d866484797a6d4ea136b287703e52f563e3091f6f75f2a451d4c5a9f82910cb0107644c1368db9d59008218a1b9d639304ed2530753ca12c4c36637da83680f8ff8911872059c3c0b86a8abe9cfef7cdbe822eb3ca1f042c2a4806235e1eb05f67b5b64ab01cc342ec78a2b378a87912543c26959d6fe80c55c9832e9626d2e650f85fa3226c6f2fc6",
            "redirect_uri" => "http://gingerbw.beget.tech"
        ];
        

        $apiClient = Http::withHeaders([
            "content-type" => "application/json",
            "User-Agent" => "amoCRM-oAuth-client/1.0",
        ])->post($link, $data);

        dd($apiClient);


     }
}
