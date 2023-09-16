<?php

namespace App\Http\classes;

use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessToken;


/**
 * Авторизация и сохранение access token в Laravel storage
 */
class AmoConnectionInitialize 
{

    public static function apiRequest(array $config): void
    {
        list('client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'auth_code' => $auth_code,
            'baseDomain' => $baseDomain) = $config;


        
        $apiClient = new AmoCRMApiClient($client_id, $client_secret, $redirect_uri);
        $accessToken = $apiClient->setAccountBaseDomain($baseDomain)
                                 ->getOAuthClient()
                                 ->getAccessTokenByCode($auth_code);



        $apiClient->setAccessToken($accessToken)
                  ->onAccessTokenRefresh(
                    function (AccessToken $accessToken, string $baseDomain) {
                        AccessTokenStorage::saveToken($accessToken, $baseDomain);
                    });
                    


        AccessTokenStorage::saveToken($accessToken, $baseDomain);
    }
 
}
    