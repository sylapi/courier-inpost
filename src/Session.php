<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use GuzzleHttp\Client;
use Sylapi\Courier\Inpost\Entities\Credentials;

class Session
{
    private $credentials;
    private $client;
    private $token;

    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
        $this->client = null;
        $this->token = $this->credentials->getPassword();
    }


    public function client(): Client
    {
        if (!$this->client) {
            $this->client = $this->initializeSession();
        }

        return $this->client;
    }

    public function token(): string
    {
        return $this->token;
    }

    public function organizationId(): string
    {
        return $this->credentials->getLogin();
    }

    private function initializeSession(): Client
    {
        $this->client = new Client([
            'base_uri' => $this->credentials->getApiUrl(),
            'headers'  => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer '.$this->token(),
            ],
        ]);

        return $this->client;
    }
}
