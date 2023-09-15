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
 


class AmoAuthController extends Controller
{
    

    protected function getToken()
    {
        $baseDomain = "gingersnaps.amocrm.ru"; 
        $client_id = 'd7424ba2-7070-4a5b-9124-dcdea55b6197';
        $client_secret = 'GIKKv84w9uNqnhO1rUTIbkIkhJhMUxDu62d4CYqBTyuP7gw61idW8iR9Vkw6bg4I';
        $auth_code = 'def5020004fc9e96d795cd4dded897c29bb1249d89c486d61b4cd5a3ab8989b9d7c42ed1fd2c91ed08860034886dd7a4e112b0195d5b4671b6baa5b13198569ae2940cd089a50e31316ea76eeac5b55d163429e4eb81cf64896aeb53339f191e85156948cbb4f7adb63889cc922eadfa7f7fdcffd2da3be82426bb21598c89e4f227b06e1cefbf0eaf9982e749881852028fad8bba527e8a95764080b59705cf6e7c89212860680e3bef9b945bea2ae06301e6370d00508dc780f1994662e74bf14ee27eefb2b0e5cd97a7023d48d11146f3e2c603ebf7548f6e017f81d07d90408f51a7f361636ea843256869973e7b25461e29ce76702ba656d8297b97a411fc37cdc7e463da514d88003d2c07b9a35cec2d7045d30dcd52aaed35daa3be370050de609c4b7297dca3cd25bb77579539ada11c6c98d3eeaf099d137ceb5589ec1c616783adaf66b8f1c2f636f3e66e1121e85d42dbce2e1c8f0c0af5cc41c1db0e29425f8f3f61eeacecaa7580df92777eeeec9e93850a0ee0841b8530efbeeb3e78b2c95d8609e973d96766a7cc5415e59ff86efdc022cd391e488cf854a28942a09433f22a0c469f277c477f527893e339f02a2f637aeb218e51fa065bcc6461247675f9341779e33e64f1a2151247ef5adc6d84211fd14c6f7041122c7da15b4061aef5371c287734';
        $redirect_uri = 'http://gingerbw.beget.tech';


        

        $apiClient = new AmoCRMApiClient($client_id, $client_secret, $redirect_uri);
        $accessToken = $apiClient->setAccountBaseDomain($baseDomain)
                                 ->getOAuthClient()
                                 ->getAccessTokenByCode($auth_code);



                                 echo $apiClient->getOAuthClient()->getOAuthButton(
                                    [
                                        'title' => 'Установить интеграцию',
                                        'compact' => true,
                                        'class_name' => 'className',
                                        'color' => 'default',
                                        'error_callback' => 'handleOauthError',

                                    ]);
                     


        $apiClient->setAccessToken($accessToken)
                  ->setAccountBaseDomain('$baseDomain')
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


        

     




 
    

        


         
     
    }
}
