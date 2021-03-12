<?php

namespace Sylapi\Courier\Inpost\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Contracts\Response;
use Sylapi\Courier\Exceptions\TransportException;
use Sylapi\Courier\Inpost\InpostCourierCreateShipment;
use Sylapi\Courier\Inpost\InpostParcel;
use Sylapi\Courier\Inpost\InpostReceiver;
use Sylapi\Courier\Inpost\InpostSender;
use Sylapi\Courier\Inpost\InpostShipment;
use Sylapi\Courier\Inpost\Tests\Helpers\InpostSessionTrait;
use Throwable;

class InpostCourierCreateShipmentTest extends PHPUnitTestCase
{
    use InpostSessionTrait;

    private function getShipmentMock()
    {
        $senderMock = $this->createMock(InpostSender::class);
        $receiverMock = $this->createMock(InpostReceiver::class);
        $parcelMock = $this->createMock(InpostParcel::class);
        $shipmentMock = $this->createMock(InpostShipment::class);

        $shipmentMock->method('getSender')
                ->willReturn($senderMock);

        $shipmentMock->method('getReceiver')
                ->willReturn($receiverMock);

        $shipmentMock->method('getParcel')
                ->willReturn($parcelMock);

        return $shipmentMock;
    }

    public function testCreateShipmentSuccess()
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 201,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/InpostCourierCreateShipmentSuccess.json'),
            ],
        ]);
        $inpostCourierCreateShipment = new InpostCourierCreateShipment($sessionMock);
        $response = $inpostCourierCreateShipment->createShipment($this->getShipmentMock());

        $this->assertInstanceOf(Response::class, $response);
        $this->assertObjectHasAttribute('shipmentId', $response);
        $this->assertNotEmpty($response->shipmentId);
        $this->assertEquals('1234567890', $response->shipmentId);
    }

    public function testCreateShipmentFailure()
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 400,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/InpostCourierCreateShipmentFailure.json'),
            ],
        ]);

        $inpostCourierCreateShipment = new InpostCourierCreateShipment($sessionMock);
        $response = $inpostCourierCreateShipment->createShipment($this->getShipmentMock());
        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(Throwable::class, $response->getFirstError());
        $this->assertInstanceOf(TransportException::class, $response->getFirstError());
    }
}
