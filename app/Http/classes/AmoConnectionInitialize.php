<?php

namespace App\Http\classes;
 
use App\Http\classes\AccessTokenHandler;
use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\OAuth\AmoCRMOAuth;
use League\OAuth2\Client\Token\AccessToken;


/**
 * Class AmoConnectionInitialize
 * 
 * Авторизация и сохранение access token в Laravel storage.
 * @package App\Http\classes
 */
class AmoConnectionInitialize
{

    private string $baseDomain;
    private string $client_id;
    private string $client_secret;
    private string $auth_code;
    private string $redirect_uri;
    public $apiClient;
    private $oAuthClient;
    private $accessToken;


    public function __construct(array $config)
    {
        $this->client_id = $config['client_id'];
        $this->client_secret = $config['client_secret'];
        $this->redirect_uri = $config['redirect_uri'];
        $this->auth_code = $config['auth_code'];
        $this->baseDomain = $config['baseDomain'];

        $this->apiClient = new AmoCRMApiClient($this->client_id, 
                                               $this->client_secret, 
                                               $this->redirect_uri);
        $this->oAuthClient = $this->apiClient->getOAuthClient();
        $this->apiOAuthRequest($this->baseDomain, $this->auth_code);
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
    