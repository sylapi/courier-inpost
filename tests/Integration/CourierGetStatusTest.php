<?php

namespace Sylapi\Courier\Inpost\Tests;

use Throwable;
use Sylapi\Courier\Contracts\Status;
use Sylapi\Courier\Enums\StatusType;
use Sylapi\Courier\Inpost\CourierGetStatuses;
use Sylapi\Courier\Exceptions\TransportException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class CourierGetStatusTest extends PHPUnitTestCase
{
    use SessionTrait;

    public function testGetStatusSuccess()
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 200,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/InpostCourierGetStatusByShipmentIdSuccess.json'),
            ],
        ]);

        $inpostCourierGetStatuses = new CourierGetStatuses($sessionMock);

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

        $inpostCourierGetStatuses = new CourierGetStatuses($sessionMock);
        $response = $inpostCourierGetStatuses->getStatus('123');
        $this->assertInstanceOf(Status::class, $response);
        $this->assertEquals(StatusType::APP_RESPONSE_ERROR, (string) $response);
        $this->assertInstanceOf(Throwable::class, $response->getFirstError());
        $this->assertInstanceOf(TransportException::class, $response->getFirstError());
    }
}
