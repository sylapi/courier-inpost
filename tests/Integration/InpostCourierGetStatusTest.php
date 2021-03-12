<?php

namespace Sylapi\Courier\Inpost\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Contracts\Status;
use Sylapi\Courier\Enums\StatusType;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Inpost\InpostCourierGetStatuses;
use Sylapi\Courier\Inpost\Tests\Helpers\InpostSessionTrait;
use Throwable;

class InpostCourierGetStatusTest extends PHPUnitTestCase
{
    use InpostSessionTrait;

    public function testGetStatusSuccess()
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 200,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/InpostCourierGetStatusByShipmentIdSuccess.json'),
            ],
        ]);

        $inpostCourierGetStatuses = new InpostCourierGetStatuses($sessionMock);

        $response = $inpostCourierGetStatuses->getStatus('123');
        // $this->assertInstanceOf(Status::class, $response);
        $this->assertEquals((string) $response, StatusType::ORDERED);
    }

    public function testGetStatusFailure()
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 404,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/InpostCourierActionFailure.json'),
            ],
        ]);

        $inpostCourierGetStatuses = new InpostCourierGetStatuses($sessionMock);
        $response = $inpostCourierGetStatuses->getStatus('123');
        $this->assertInstanceOf(Status::class, $response);
        $this->assertEquals(StatusType::APP_RESPONSE_ERROR, (string) $response);
        $this->assertInstanceOf(Throwable::class, $response->getFirstError());
        $this->assertInstanceOf(TransportException::class, $response->getFirstError());
    }
}
