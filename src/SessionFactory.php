<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Inpost\Entities\Credentials;

class SessionFactory
{
    private $sessions = [];

    const API_LIVE = 'https://api-shipx-pl.easypack24.net';
    const API_SANDBOX = 'https://sandbox-api-shipx-pl.easypack24.net';

    public function session(Credentials $credentials): Session
    {
        $apiUrl = $credentials->isSandbox() ? self::API_SANDBOX : self::API_LIVE;

        $credentials->setApiUrl($apiUrl);

        $key = sha1( $apiUrl.':'.$credentials->getLogin().':'.$credentials->getPassword());

        return (isset($this->sessions[$key])) ? $this->sessions[$key] : ($this->sessions[$key] = new Session($credentials));
    }
}
