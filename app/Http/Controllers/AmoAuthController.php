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
        $client_id = 'd6b82438-952d-4558-ae25-9c1588ddbf2c';
        $client_secret = 'yPwX6EdaKFS3tprEhp5al5xqrE3vUJlEAsf6b1OvZkoESJq1cF7DeKi95W0JV2Qs';
        $redirect_uri = 'http://gingerbw.beget.tech';
        $autorization_code = 'def502006dba850e168e18a530901b2c5ab748039bf18aee0c27153b93d38f4217c4b459167657c4b9fd8aacd51bb6aba436f11e78bd2da8e8cf93e61ea221da22612ee699bb2fe18e125fdfa14e92322ba1c2f0bc52683b95d9f191112d064a379601bd9ce8fd37c82877cf972f54453de4f1c7134dbe316782575a4ff0a27f503822332f5b93084b8954fc96ceef2a180dda0de4fb15e7b8253a4c5f844bd85033d332e373dc87938a01e80b9559ee0937af34437bb4bf06527b63bcd887167d6fb7ea103de86788c499e4d553ba038ddbd436f49fc2f4ac6e243f1cbc359ae520b20311719b8a3913a9afd587c81d44bd404bd3d2def1a7c8b911f08bed8846ee0ca7f24c91fe3e61caea02df2ce596e90a7b3e3d5622f80d97df21d5069ab38093156a9583dda80812e8a5cfe6ca15850ef3057ff03cfb892cf5c191a7a2fb40b2dc52e22a55b8c3e1741e06c7b7d5b3e6b7a777e47445b977b50cbebd5747465483114a0870a95ab6decacbd4fa0a82688943be8115a9e0862d71f7739b10287cc8a0b5f6eee32facaac4cb93eeea081b0b95a46b63f7d047575ab241304180f5a891b6e75f40f72615368247b7b5738256ed60c12e87fa92ee1573067e4f1b5a9294406f55f5e0203e9783cd4fa15dd176e44f8e0ecd5f874e299e204b265972d8e447f17becfcf6';

        $apiClient = new AmoCRMApiClient($client_id, $client_secret, $redirect_uri);
        $accessToken = $apiClient->getOAuthClient()->getAccessTokenByCode($autorization_code);

        dd($accessToken);



    }
}
