<?php

namespace Sylapi\Courier\Inpost\Tests;

use Throwable;
use Sylapi\Courier\Contracts\Response;
use Sylapi\Courier\Inpost\Entities\Parcel;
use Sylapi\Courier\Inpost\Entities\Sender;
use Sylapi\Courier\Inpost\Entities\Receiver;
use Sylapi\Courier\Inpost\Entities\Shipment;
use Sylapi\Courier\Exceptions\TransportException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Inpost\Tests\Helpers\SessionTrait;

class CourierCreateShipmentTest extends PHPUnitTestCase
{
    use SessionTrait;

    private function getShipmentMock()
    {
        $senderMock = $this->createMock(Sender::class);
        $receiverMock = $this->createMock(Receiver::class);
        $parcelMock = $this->createMock(Parcel::class);
        $shipmentMock = $this->createMock(Shipment::class);

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
        $inpostCourierCreateShipment = new CourierCreateShipment($sessionMock);
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

        $inpostCourierCreateShipment = new CourierCreateShipment($sessionMock);
        $response = $inpostCourierCreateShipment->createShipment($this->getShipmentMock());
        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(Throwable::class, $response->getFirstError());
        $this->assertInstanceOf(TransportException::class, $response->getFirstError());
    }
}
