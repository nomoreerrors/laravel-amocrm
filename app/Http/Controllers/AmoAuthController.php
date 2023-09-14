<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use AmoCRM\Client\AmoCRMApiClient;
use Carbon\Exceptions\Exception;
use Spatie\FlareClient\Api;

class AmoAuthController extends Controller
{
    
    protected function getSponsor(Request $request)
    {
      echo 'Im here!!!!!!!';
    }


    protected function getToken()
    {
        $client_id = 'c619beb0-3934-4354-8b73-515ce57573ee';
        $client_secret = 'i0DDmNODe146gokSR8gc2vRVkfhLneiBSjEYlM9Qxoyg92W7PeKiSlIEPD1CmKyH';
        $redirect_uri = 'http://gingerbw.beget.tech';
        $autorization_code = 'def502005f88192b1184d553ffdb13b3d865be9787006fb25253e942f177482a8a2f7b4373bb5f6a953ca168a3ce83c65fe61cc6f341246818fdd55fc24c4843292893a7486f787ab3fea5811919121960ab53d578411caa0b0eed9449f0839a1ee3c162648621413219f34d61b0d536db8997346cdfb77b926ca353188d3712ff9696a7e505ec364b641f0f62224de0d9aacc690bd4e34689432fc1f17d5a62dea8acb6616efb874fb3d4fecbaa61aceca23c13a2bf98b7f7115f14b7fed0b79ae27f02167766615f3ba4b9ea81898be70642cc845281916385a0ea9a053c9c8c2d8993afaab55f96f713bf5910b39d0b813d220b554d67011cc4934eb067a55be7ee7519d81f7896ac8484974c8c294efa6f5128c542f2953b629192ddd5872d1b46a705425ef9ccd3a32cacff0dc674d664d67f9e9a6dd66523f57d8866f03fa9dd7e939cb27ee32911f73449fb83a6f60ff7ca2f24476bb18354fcfdd1e9cb27af0a2fd92bf7dc0dd33e3452e94d3b1a65738fd4e2b98fb5e20f5a9d777af553850e6365952ab948918db5c3e9cc0d2fde30e9bb3cf7cd8c2688ba3a7a835ba24b4a949b932f936d3e0db16318a7f98a0eab8e4820c6dc876de43f25577053a25768d6a43bd511ff51e987609ae0444f45690647c199710b509668e1145b8dc06896fe4147dcd0f51c';
        $state = bin2hex(random_bytes(16));
        http://gingerbw.beget.tech/?code=def502009358c351c456b8c3e8bf79b1969d36f7f251068b1b31ab5781d1bb9d6c5b533fc3cc5a23e90ae39b51e988d8b9c23f0d6fcd995d866012eff5b95c6010d98391d72ec4ff05384c7b5174825a6bf57be092644381e30f5a2c0e25af2d240b3aaeb2321325ba4f5634cd409aba8ff190fe6f9956e8e30b0709cabb3b3574567946e5562b445b2c5c6da8246c7c49f797a4f84f5606a9cc73d939d2b2e824d3a1a9910be15b48a31f70314722e88e914b9611eef31b2215231f8f8c6b941dc464a5471234135a9e671da9c63d6990e658aa4bdd1fe3efea2013602809eb050cd4f38d87cc61d65b37c60673c6e3de7c6cf29a8517e0790d021d0dbab87f028133825d1bfe9d5d180228252c21d8040b8661ff43588a182158a978dcccc3620e8e6156e07c274e9220ffc080f0b39de7420fc4b24ab16af4552eecf13dc4e674e7dae06cc0ecee4f6f58d56d417096d3f8abedc2fa62ee7be14b200a6ee912eaee555f160237c5400417bde1a8b774b394c38bb86e4ddb973e4bdca0944cd88dd8262aef08bb7a4cef124460deb1516ad0dd6e141c9778bc1c420f0aa3b60a523f8f0ae2841176c2371559b896ca1f68da41f1e19c9aef03e935e2789c1bf0549da07068086bb9a7f6c9604edde27d34fb9382481e69ec6467be029aa3dd54421c3450b9abb70e7b63&state=18a261e70b30ae837eb2c55e91a486ea&referer=gingersnaps.amocrm.ru&platform=1&client_id=c619beb0-3934-4354-8b73-515ce57573ee
         

        

        $apiClient = new AmoCRMApiClient($client_id, $client_secret, $redirect_uri);


            if (isset($_GET['referer'])) {
                $apiClient->setAccountBaseDomain($_GET['referer']);
            }


            if (!isset($_GET['code'])) {
                $state = bin2hex(random_bytes(16));
                $_SESSION['oauth2state'] = $state;
                if (isset($_GET['button'])) {
                    echo $apiClient->getOAuthClient()->getOAuthButton(
                        [
                            'title' => 'Установить интеграцию',
                            'compact' => true,
                            'class_name' => 'className',
                            'color' => 'default',
                            'error_callback' => 'handleOauthError',
                            'state' => $state,
                        ]
                    );
                    die;
                } else {
                    $authorizationUrl = $apiClient->getOAuthClient()->getAuthorizeUrl([
                        'state' => $state,
                        'mode' => 'post_message',
                    ]);
                    header('Location: ' . $authorizationUrl);
                    die;
                }
            } elseif (!isset($_GET['from_widget']) && (empty($_GET['state']) || empty($_SESSION['oauth2state']) || ($_GET['state'] !== $_SESSION['oauth2state']))) {
                unset($_SESSION['oauth2state']);
                exit('Invalid state');
            }

            /**
             * Ловим обратный код
             */
            try {
                $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($_GET['code']);

                if (!$accessToken->hasExpired()) {
                    saveToken([
                        'accessToken' => $accessToken->getToken(),
                        'refreshToken' => $accessToken->getRefreshToken(),
                        'expires' => $accessToken->getExpires(),
                        'baseDomain' => $apiClient->getAccountBaseDomain(),
                    ]);
                }
            } catch (Exception $e) {
                die((string)$e);
            }

            $ownerDetails = $apiClient->getOAuthClient()->getResourceOwner($accessToken);

            printf('Hello, %s!', $ownerDetails->getName());



 

        // {
        // curl https://gingerbw.amocrm.ru/oauth2/access_token -d \
        // '{"client_id":"c619beb0-3934-4354-8b73-515ce57573ee","client_secret":"5OWp4jw9Y4qvnGPZ3IzJbY6PDD2KoxgNM6c5FmFHK2G1hGDpwfogTW4uryPq0MGU","grant_type":"authorization_code","code":"def50200919672bb6c46dd8015ee7cc93a91be9771fd65ba23a02fd908f00b4a4be7ebed5b053a456673c9d5188eb06fe329311ac95cbd0e0ae4437a5437c953d6e9cb64bb86e16f13803e7f965b8771540f83bac74f71746e5951dd68e2658a472fc9f23871d767786d0dc72d12d9b4e31bf2567d1fc41ce7c0286baa5e2a180dea5f8731425ccc5e9c46c87e946895d849d91d5ad176ec3053b3f96a4930f674c3e2ce71a83e8a80f9fce8194469b77ed82320c1d5761463f9e5d34b715cefcb88aadb258517ec4fb1e68083692696316aab74b66841b9bb91a28ab5c4ca77885fce819ae0c9fa1ddd95fe54bbfdfd925e2c7fa08f7254b99a4e00ef7e327f97429a56287e0c82954cb5c9a15941889347f91e572cb71641e1c1f2ccfd2d607a3e5f00209eb26f84047015fd7f02c23fa30fe839c18b91dfaad1fe772380c201a3fca949f88468635ec3606c9b988c87b9e7bf2a9346890965f58bf047190cfbbf5acd97fe4774564eb23c36edec9d70d51fee3eb8814baccd051aeadb848a504e9328d207ad790ee0d92e461b6b8958930e3875950b3c6520ea3a9ef27c5cbb35e2cac649f4328322177372fe587eaaa60c3244474445627d75a53474fa63123a3b476101bdaef06d347bcfa417dd91754f8bcde038bb09370119951d7758c65763cd7a589c76139930","redirect_uri":"http://gingerbw.beget.tech"}' \
        // -H 'Content-Type:application/json' \
        // -X POST
            // }


    }
}
