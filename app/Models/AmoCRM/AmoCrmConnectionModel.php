<?php

namespace App\Models\AmoCRM;
 
use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\OAuth\AmoCRMOAuth;
use App\Http\classes\AmoCRMRepository;
use League\OAuth2\Client\Token\AccessToken;
use App\Models\AmoCRM\BaseAmoCrmConnectionModel;


/**
 * Авторизация и сохранение access token в Laravel storage.
 */
class AmoCrmConnectionModel extends BaseAmoCrmConnectionModel
{
    public function connect(object $config)
    {

        $this->apiClient = new AmoCRMApiClient($config->client_id, $config->client_secret, $config->redirect_uri);
        $this->apiOAuthRequest($config->baseDomain, $config->auth_code);

    }


    
    private function apiOAuthRequest($baseDomain, $auth_code)
    {

        $this->apiClient->setAccountBaseDomain($baseDomain);
        $token = AmoCRMRepository::getTokenFromStorage();
        if(!$token) {
            $this->accessToken = $this->apiClient
                                      ->getOAuthClient()
                                      ->getAccessTokenByCode($auth_code);
        } else {
            $this->accessToken =  $token;
          
        }   



        $this->apiClient->setAccessToken($this->accessToken)
                  ->onAccessTokenRefresh(
                    function (AccessToken $accessToken, string $baseDomain) {
                        AmoCRMRepository::saveTokenToStorage($accessToken, $baseDomain);
                    });
 
        if(!$token) {
            AmoCRMRepository::saveTokenToStorage($this->accessToken, $baseDomain);
        }
            
    }


    
    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }



    public function getOauthClient(): AmoCRMOAuth
    {
        return $this->apiClient->getOauthClient();
    }







    
 
}
    