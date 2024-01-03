<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use GuzzleHttp\Client;
use Sylapi\Courier\Inpost\Session;
use Sylapi\Courier\Inpost\Parameters;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class SessionTest extends PHPUnitTestCase
{
    public function testInpostSessionParameters()
    {
        $inpostSession = new Session(Parameters::create([
            'apiUrl'    => 'https://test.inpost.api',
            'token'     => 'asdef12345',
        ]));
        $this->assertInstanceOf(Client::class, $inpostSession->client());
    }
}
