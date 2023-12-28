<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Inpost\InpostParameters;
use Sylapi\Courier\Inpost\InpostSession;

class SessionTest extends PHPUnitTestCase
{
    public function testInpostSessionParameters()
    {
        $inpostSession = new Session(InpostParameters::create([
            'apiUrl'    => 'https://test.inpost.api',
            'token'     => 'asdef12345',
        ]));
        $this->assertInstanceOf(InpostParameters::class, $inpostSession->parameters());
        $this->assertInstanceOf(Client::class, $inpostSession->client());
    }
}
