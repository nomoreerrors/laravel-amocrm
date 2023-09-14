<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use AmoCRM\Client\AmoCRMApiClient;
use Carbon\Exceptions\Exception;
use League\OAuth2\Client\Token\AccessToken;
use Spatie\FlareClient\Api;


class AmoAuthController extends Controller
{
    

    protected function getToken()
    {
        $subdomain = 'gingersnaps'; 
        $link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; 
        $data = [
            'client_id' => 'd7424ba2-7070-4a5b-9124-dcdea55b6197',
            'client_secret' => 'RbJp1sK09tnpWYI6woixo3b73RP1B4efxvC9IHPUAnV48xCQZSTCz5UVUuybTMkP',
            'grant_type' => 'authorization_code',
            'code' => 'def50200e0f6e3419007004dc2ae627374f6a16568c31c5948e8314200e4b6f8cca95746d9e852bc5640305b91ac083f451361b0ab8946ccaf809433f53843a01f6968f876905e7c781724e58101882669d2abf5f364d031a778a9129af3b7e7300a79053b79b14c56128cdfc3d3d1c366a4ec8f696dd7792496722079a24b2fe641ea2796b8548825c49dcec4ef237733b0a56cc771ede1eb248ec318eee7460d69d355e9d5d2d6fb66cb5a4104a414c9eb91c6e7c3edb064dc382dcaabe6291e5954a619a20472cff52e2dc484fc591b41eefa3e3bb4a496ba41e546508ceb186969e57c98b3aff6a9a7ac915cbb900f40c4e8fefabd29645a9214604831bc5c9969feafbbe708192fd08c5d73b950e83c7b04a9cbdc5c118e0d00bedf49cc8ede9707de425a4b6cdb78ecbd97b4ed56ac2eb04f6ea212f2ea48ca61ed5aa0307b1a3fc3efb670fe6784f1454a49f793d22df1d239839e950841d7f60b55037c179519d14732c1648ccaa067aaf2f4eb6559dd3a9ae7728221925a1378bc2cfd5e2b02b3b8f763a1abfdce3cdc81fada561af5cc12a5bd52338c12ba6cac6e45b3699896366657edf91cb7c83a5cfe2000e570b2010b187503336970056ab88b8b33507f8d2270a3df8d8c0d4e7af02ea89063f82a1f910686d3e494d6ec9068230a56cf9a504da7507b',
            'redirect_uri' => 'http://gingerbw.beget.tech',
        ];

       

        $out = Http::withHeaders([
                        'User-Agent' => 'amoCRM-oAuth-client/1.0',
                        'Content-Type' => 'application/json'
                    ])->post($link, $data);

        $response = json_decode($out, true); //преобразование строки JSON в массив
        echo '<h1>SUCCESS</h1>';

        
        $access_token = new AccessToken($response); 
        $refresh_token = $response['refresh_token'];  
        $token_type = $response['token_type']; 
        $expires_in = $response['expires_in'];

        $apiClient = new AmoCRMApiClient($data['client_id'], $data['client_secret'], $data['redirect_uri']);
        $apiClient->setAccessToken($access_token);
        $tokenIsBack = $apiClient->getAccessToken();
        dd($tokenIsBack);

     
    }
}
