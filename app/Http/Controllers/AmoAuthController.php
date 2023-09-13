<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use AmoCRM\Client\AmoCRMApiClient;
use Carbon\Exceptions\Exception;

class AmoAuthController extends Controller
{

   
    
    protected function getToken()
    {
        $subdomain = "gingersnaps"; 
        $link = "https://" . $subdomain . ".amocrm.ru/oauth2/access_token"; 


        $client_id = 'd7424ba2-7070-4a5b-9124-dcdea55b6197';
        $client_secret = 'bZUwoWU8VSVJuDkcQbTExGnlq54m1PejFlEvu769b8kaAGG3qGihD9aWRreHfLqa';
        $redirect_uri = 'gingerbw.beget.tech';


        $apiClient = new AmoCRMApiClient($client_id, $client_secret, $redirect_uri);
        $apiClient->setAccountBaseDomain('gingerbw.beget.tech');



        $state = bin2hex(random_bytes(16));
        $_SESSION['oauth2state'] = $state;
        $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($client_secret);
    
        $authorizationUrl = $apiClient->getOAuthClient()->getAuthorizeUrl([
            'state' => $state,
            'mode' => 'post_message',
        ]);
        header('Location: ' . $authorizationUrl);
        


        if (!$accessToken->hasExpired()) {
            saveToken([
                'accessToken' => $accessToken->getToken(),
                'refreshToken' => $accessToken->getRefreshToken(),
                'expires' => $accessToken->getExpires(),
                'baseDomain' => $apiClient->getAccountBaseDomain(),
            ]);
        };
        

        dd($accessToken);

        // $apiClient = Http::withHeaders([
        //     "content-type" => "application/json",
        //     "User-Agent" => "amoCRM-oAuth-client/1.0",
        // ])->post($link, $data);




     }
}
