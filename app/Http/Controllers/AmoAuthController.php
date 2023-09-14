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
    
    protected function getToken()
    {
        $client_id = 'c619beb0-3934-4354-8b73-515ce57573ee';
        $client_secret = 'i0DDmNODe146gokSR8gc2vRVkfhLneiBSjEYlM9Qxoyg92W7PeKiSlIEPD1CmKyH';
        $redirect_uri = 'http://gingerbw.beget.tech';
        $autorization_code = 'def502005f88192b1184d553ffdb13b3d865be9787006fb25253e942f177482a8a2f7b4373bb5f6a953ca168a3ce83c65fe61cc6f341246818fdd55fc24c4843292893a7486f787ab3fea5811919121960ab53d578411caa0b0eed9449f0839a1ee3c162648621413219f34d61b0d536db8997346cdfb77b926ca353188d3712ff9696a7e505ec364b641f0f62224de0d9aacc690bd4e34689432fc1f17d5a62dea8acb6616efb874fb3d4fecbaa61aceca23c13a2bf98b7f7115f14b7fed0b79ae27f02167766615f3ba4b9ea81898be70642cc845281916385a0ea9a053c9c8c2d8993afaab55f96f713bf5910b39d0b813d220b554d67011cc4934eb067a55be7ee7519d81f7896ac8484974c8c294efa6f5128c542f2953b629192ddd5872d1b46a705425ef9ccd3a32cacff0dc674d664d67f9e9a6dd66523f57d8866f03fa9dd7e939cb27ee32911f73449fb83a6f60ff7ca2f24476bb18354fcfdd1e9cb27af0a2fd92bf7dc0dd33e3452e94d3b1a65738fd4e2b98fb5e20f5a9d777af553850e6365952ab948918db5c3e9cc0d2fde30e9bb3cf7cd8c2688ba3a7a835ba24b4a949b932f936d3e0db16318a7f98a0eab8e4820c6dc876de43f25577053a25768d6a43bd511ff51e987609ae0444f45690647c199710b509668e1145b8dc06896fe4147dcd0f51c';
        $state = bin2hex(random_bytes(16));

        $apiClient = new AmoCRMApiClient($client_id, $client_secret, $redirect_uri);
        $authorizationUrl = $apiClient->getOAuthClient()->getAuthorizeUrl([
            'state' => $state,
            'mode' => 'post_message',
        ]);

        header('Location: ' . $authorizationUrl);



        // $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($autorization_code);

        // if (!$accessToken->hasExpired()) {
        //     saveToken([
        //         'accessToken' => $accessToken->getToken(),
        //         'refreshToken' => $accessToken->getRefreshToken(),
        //         'expires' => $accessToken->getExpires(),
        //         'baseDomain' => $apiClient->getAccountBaseDomain(),
        //     ]);
        // }

        // dd($accessToken);
    }
}
