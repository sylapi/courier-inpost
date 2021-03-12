<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

class InpostSessionFactory
{
    private $sessions = [];
    private $parameters;

    //These constants can be extracted into injected configuration
    // const API_LIVE = 'https://api-shipx-pl.easypack24.net';
    const API_LIVE = 'https://live.inpost.test';
    const API_SANDBOX = 'https://sandbox-api-shipx-pl.easypack24.net';

    public function session(InpostParameters $parameters): InpostSession
    {
        $this->parameters = $parameters;
        $this->parameters->apiUrl = ($this->parameters->sandbox) ? self::API_SANDBOX : self::API_LIVE;

        $key = sha1($this->parameters->apiUrl.':'.$this->parameters->token);

        return (isset($this->sessions[$key])) ? $this->sessions[$key] : ($this->sessions[$key] = new InpostSession($this->parameters));
    }
}
