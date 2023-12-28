<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

class SessionFactory
{
    private $sessions = [];
    private $parameters;

    const API_LIVE = 'https://api-shipx-pl.easypack24.net';
    const API_SANDBOX = 'https://sandbox-api-shipx-pl.easypack24.net';

    public function session(InpostParameters $parameters): InpostSession
    {
        $this->parameters = $parameters;
        $this->parameters->apiUrl = ($this->parameters->sandbox) ? self::API_SANDBOX : self::API_LIVE;

        $key = sha1($this->parameters->apiUrl.':'.$this->parameters->token);

        return (isset($this->sessions[$key])) ? $this->sessions[$key] : ($this->sessions[$key] = new Session($this->parameters));
    }
}
