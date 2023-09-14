<?php

declare(strict_types=1);

namespace AmoCRM\OAuth;

/**
 * Класс для настроек Oauth клиента
 * Interface CrmOauthConfigInterface
 *
 * @package AmoCRM\OAuth
 */
class OAuthConfig implements OAuthConfigInterface
{
    /**
     * @var $client_id
     */
    private string $client_id;

    /**
     * @var $client_id
     */
    private string $client_secret;

    /**
     * @var $client_id
     */
    private string $redirect_uri;



    public function __construct(string $client_id, string $client_secret, string $redirect_uri)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
    }



    /**
     * @return string
     */
    public function getIntegrationId(): string
    {
        return $this->client_id;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->client_secret;
    }

    /**
     * @return string
     */
    public function getRedirectDomain(): string
    {
        return $this->redirect_uri;
    }
}
