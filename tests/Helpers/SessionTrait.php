<?php

namespace Sylapi\Courier\Inpost\Tests\Helpers;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Sylapi\Courier\Inpost\Parameters;
use Sylapi\Courier\Inpost\Session;

trait SessionTrait
{
    private function getSessionMock(array $responses)
    {
        $responseMocks = [];

        foreach ($responses as $response) {
            $responseMocks[] = new Response((int) $response['code'], $response['header'], $response['body']);
        }

        $mock = new MockHandler($responseMocks);

        $handlerStack = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handlerStack]);

        $parametersMock = $this->createMock(Parameters::class);
        $parametersMock->organization_id = '1234567890';
        $parametersMock->token = '01b307acba4f54f55aafc33bb06bbbf6ca803e9a';
        $parametersMock->method('getDispatchPoint')
            ->willReturn(['dispatch_point_id' => '11111']);

        $sessionMock = $this->createMock(Session::class);
        $sessionMock->method('client')
            ->willReturn($client);
        $sessionMock->method('parameters')
            ->willReturn($parametersMock);

        return $sessionMock;
    }
}
