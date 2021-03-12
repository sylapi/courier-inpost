<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Inpost\InpostParameters;
use Sylapi\Courier\Inpost\InpostSession;
use GuzzleHttp\Client;

class InpostSessionTest extends PHPUnitTestCase
{
    public function testInpostSessionParameters()
    {
        $inpostSession = new InpostSession(InpostParameters::create([
            'apiUrl'    => 'https://test.inpost.api',
            'token'     => 'asdef12345',
        ]));
        $this->assertInstanceOf(InpostParameters::class, $inpostSession->parameters());
        $this->assertInstanceOf(Client::class, $inpostSession->client());
    }
}
