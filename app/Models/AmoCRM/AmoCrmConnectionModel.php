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
  
    

    public function connect($config): void
    {

        $this->apiClient = new AmoCRMApiClient($config->client_id, $config->client_secret, $config->redirect_uri);
        $this->oAuthClient = $this->apiClient->getOAuthClient();
        $this->apiOAuthRequest($config->baseDomain, $config->auth_code);
    }


    
    private function apiOAuthRequest($baseDomain, $auth_code)
    {

        $this->apiClient->setAccountBaseDomain($baseDomain);
        $a = AmoCRMRepository::getTokenFromStorage();
        if(!$a) {
            $this->accessToken = $this->apiClient
                                      ->getOAuthClient()
                                      ->getAccessTokenByCode($auth_code);
        } else {
            $this->accessToken =  $a;
          
        }   



        $this->apiClient->setAccessToken($this->accessToken)
                  ->onAccessTokenRefresh(
                    function (AccessToken $accessToken, string $baseDomain) {
                        AmoCRMRepository::saveTokenToStorage($accessToken, $baseDomain);
                    });
 
        if(!$a) {
            AmoCRMRepository::saveTokenToStorage($this->accessToken, $baseDomain);
        }
            
    }


    
    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }



    public function getOauthClient(): AmoCRMOAuth
    {
        return $this->oAuthClient;
    }







    
 
}
    