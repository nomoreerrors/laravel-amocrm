<?php

namespace App\Http\classes;

use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessToken;
use App\Http\classes\AccessTokenHandler;


/**
 * Авторизация и сохранение access token в Laravel storage
 */
class AmoConnectionInitialize 
{

    private $baseDomain;
    private $client_id;
    private $client_secret;
    private $auth_code;
    private $redirect_uri;


    public function __construct(array $config)
    {
        $this->client_id = $config['client_id'];
        $this->client_secret = $config['client_secret'];
        $this->redirect_uri = $config['redirect_uri'];
        $this->auth_code = $config['auth_code'];
        $this->baseDomain = $config['baseDomain'];

        $this->apiRequest($this->client_id, $this->client_secret, $this->redirect_uri, $this->baseDomain, $this->auth_code);
    }




    private function apiRequest($client_id, $client_secret, $redirect_uri, $baseDomain, $auth_code)
    {
        $apiClient = new AmoCRMApiClient($client_id, $client_secret, $redirect_uri);
        $accessToken = $apiClient->setAccountBaseDomain($baseDomain)
                                 ->getOAuthClient()
                                 ->getAccessTokenByCode($auth_code);

        


        $apiClient->setAccessToken($accessToken)
                  ->onAccessTokenRefresh(
                    function (AccessToken $accessToken, string $baseDomain) {
                        AccessTokenHandler::saveTokenToStorage($accessToken, $baseDomain);
                    });
                    


        AccessTokenHandler::saveTokenToStorage($accessToken, $baseDomain);
    }
 
}
    