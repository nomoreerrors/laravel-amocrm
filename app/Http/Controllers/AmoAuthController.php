<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use AmoCRM\Client\AmoCRMApiClient;
use Carbon\Exceptions\Exception;
use League\OAuth2\Client\Token\AccessToken;
use Spatie\FlareClient\Api;
use League\OAuth2\Client\Provider\RequestProvider;
use Illuminate\Support\Facades\Storage;
use \League\OAuth2\Client\Token\AccessTokenInterface;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use \AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use App\Http\classes\AccessTokenStorage;
use App\Providers\AppServiceProvider;


class AmoAuthController extends Controller
{
    /**
     * Аутентификация по коду и получение access token
     */
    protected function authByCode(): void
    {
        $baseDomain = "gingersnaps.amocrm.ru"; 
        $client_id = 'd6b82438-952d-4558-ae25-9c1588ddbf2c';
        $client_secret = 'yMhFfxrrtvcIf75564N8QEeH7G3CartHAq8joQYPuFKjyQiSI541uHA2rNdcMVWL';
        $auth_code = 'def502006bca1f0f4aa14dc905fde2d1013aa7734c23c5d9f1c795d78b309c146e8c232583a767e22c4093941b5525ca63f72829d7992c1a45c83545b218b587e9ad7f67dcc1cdf5dfd82e18c320f66104ed27908c38514295737de83318633ecc1747431b06fec93266e240d673d12605fada1db4e676d86fcb17603e13c7baee59f08000b2209ef4029eae5939ca78722fd727df6ee853db0b700045acc44d376a8848721993972d3b9b8c04ce5d4abdd6608be408445d18d6fe4fbd8c0b7fc511769951912fe8318d09ec1d14fddda305215f61739c113e8f7940076ac99d84147c9bc2dd9f1b93adeee89744689d8966b0c71bf16fd4a31c3aeb5b968396b73dff60e77613701700c37e3724ebce3fbfe9b1a2a3ea3112873d900da35ed817d577e2ac25ae7eeb0e9faaab96eceab16d9e8fd31fa7ed5d241c1b94be85dc1880e7daeb2867718fed09ace63d74982dd2ae3542242c1016398b646ec3504eb642df9a308c3eb6359bcb86a6d8e7b6cf1b17c80e7ae2360a68af6cf4584f920f694e11b3b6642f16f8da025af4a45c919e9cee115b94d1ad740f9f5f9c5cd55acad914c054095da442181b697083b6b24c1bdac0bfa61a6626b3f6d5b866a56b37bf8d69e68c8963f37b7c45d7577a382297c442eea716fecb1813271775cf14d42e7ba963e9e6c8bc4c';
        $redirect_uri = 'http://gingerbw.beget.tech';



        $apiClient = new AmoCRMApiClient($client_id, $client_secret, $redirect_uri);
        $accessToken = $apiClient->setAccountBaseDomain($baseDomain)
                                 ->getOAuthClient()
                                 ->getAccessTokenByCode($auth_code);



        $apiClient->setAccessToken($accessToken)
                  ->onAccessTokenRefresh(
                    function (AccessTokenInterface $accessToken, string $baseDomain) {
                            Storage::put('access_token.txt', json_encode(
                                    [
                                        'accessToken' => $accessToken->getToken(),
                                        'refreshToken' => $accessToken->getRefreshToken(),
                                        'expires' => $accessToken->getExpires(),
                                        'baseDomain' => $baseDomain,
                                    ]
                                    ));
        });

        AccessTokenStorage::saveToken($accessToken, $baseDomain);

        $token = AccessTokenStorage::getToken();
        dd($token);
        

     
       



 
    

        


         
     
    }
}
