<?php

namespace App\Http\classes;


/**
 * Конфиг для получения access token
 */
class AmoCRMConfig
{
    public string $baseDomain;
    public string $client_id;
    public string $client_secret;
    public string $auth_code;
    public string $redirect_uri;
    public string $state;

    public function __construct()
    {

        $this->baseDomain = env('AMOCRM_BASE_DOMAIN');
        $this->client_id = env('AMOCRM_CLIENT_ID');
        $this->client_secret = env('AMOCRM_CLIENT_SECRET');
        $this->auth_code = env('AMOCRM_AUTH_CODE');
        $this->redirect_uri = env('AMOCRM_REDIRECT_URI');
        $this->state = env('AMOCRM_STATE');
    }
        
}