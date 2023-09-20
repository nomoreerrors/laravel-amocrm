<?php

namespace App\Http\classes;

use Illuminate\Support\Facades\Storage;
use League\OAuth2\Client\Token\AccessToken;


class AccessTokenHandler extends AccessToken

/**
 * Put token to Laravel storage
 */
{
    public static function saveTokenToStorage(AccessToken $accessToken, string $baseDomain): void
    {
        if (
            $accessToken->getToken() &&
            $accessToken->getRefreshToken() &&
            $accessToken->getExpires() &&
            $baseDomain
        ) {
            Storage::put('access_token.txt', json_encode(
                [
                    'accessToken' => $accessToken->getToken(),
                    'refreshToken' => $accessToken->getRefreshToken(),
                    'expires' => $accessToken->getExpires(),
                    'baseDomain' => $baseDomain
                ]
                ));

            echo 'Token is saved';
            
        } else {
            exit('Invalid access token ' . var_export($accessToken, true));
        }
        
    }


    /**
     * Get token from Laravel storage
     */

    public static function getTokenFromStorage(): AccessToken
    {
        if (!Storage::get('access_token.txt')) {
            exit('Access token file not found');
        }

        $accessToken = json_decode(Storage::get('access_token.txt'), true);

        if (
            isset($accessToken)
            && isset($accessToken['accessToken'])
            && isset($accessToken['refreshToken'])
            && isset($accessToken['expires'])
            && isset($accessToken['baseDomain'])
        ) {
            return new AccessTokenHandler([
                'access_token' => $accessToken['accessToken'],
                'refresh_token' => $accessToken['refreshToken'],
                'expires' => $accessToken['expires'],
                'baseDomain' => $accessToken['baseDomain'],
            ]);
            
        } 
        else {
            exit('Invalid access token ' . var_export($accessToken, true));
        }
    }
}

