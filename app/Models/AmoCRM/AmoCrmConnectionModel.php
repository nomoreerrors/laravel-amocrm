<?php

namespace App\Models\AmoCRM;
 
use App\Http\classes\AccessTokenHandler;
use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\OAuth\AmoCRMOAuth;
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
        $a = AccessTokenHandler::getTokenFromStorage();
        // dd($a);
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
                        AccessTokenHandler::saveTokenToStorage($accessToken, $baseDomain);
                    });
 
        if(!$a) {
         AccessTokenHandler::saveTokenToStorage($this->accessToken, $baseDomain);
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
    