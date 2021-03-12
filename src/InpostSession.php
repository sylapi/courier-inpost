<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use GuzzleHttp\Client;

class InpostSession
{
    private $parameters;
    private $client;
    private $token;

    public function __construct(InpostParameters $parameters)
    {
        $this->parameters = $parameters;
        $this->client = null;
        $this->token = $this->parameters->token ?? null;
    }

    public function parameters(): InpostParameters
    {
        return $this->parameters;
    }

    public function client(): Client
    {
        if (!$this->client) {
            $this->initializeSession();
        }

        return $this->client;
    }

    public function token(): string
    {
        return $this->token;
    }

    private function initializeSession(): void
    {
        $this->client = new Client([
            'base_uri' => $this->parameters->apiUrl,
            'headers'  => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer '.$this->token(),
            ],
        ]);
    }
}
