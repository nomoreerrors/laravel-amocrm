<?php

declare(strict_types=1);

namespace AmoCRM\OAuth;

use League\OAuth2\Client\Token\AccessTokenInterface;
use Illuminate\Support\Facades\Storage;

/**
 * Сервис, который может сохраняет oauth токены
 * Interface CrmOauthServiceInterface
 *
 * @package AmoCRM\OAuth
 */
class OAuthService implements OAuthServiceInterface
{
    /**
     * @param AccessTokenInterface $accessToken
     * @param string               $baseDomain
     */
    public function saveOAuthToken(AccessTokenInterface $accessToken, string $baseDomain): void
    {
        Storage::put($accessToken, $baseDomain);
    }

}
