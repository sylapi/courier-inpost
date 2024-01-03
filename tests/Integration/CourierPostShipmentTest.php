<?php

namespace Sylapi\Courier\Inpost\Tests\Integration;

use Throwable;
use Sylapi\Courier\Contracts\Response;
use Sylapi\Courier\Inpost\Entities\Booking;
use Sylapi\Courier\Inpost\CourierPostShipment;
use Sylapi\Courier\Exceptions\TransportException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class CourierPostShipmentTest extends PHPUnitTestCase
{
    use SessionTrait;

    private function getBookingMock($shipmentId)
    {
        $bookingMock = $this->createMock(Booking::class);
        $bookingMock->method('getShipmentId')->willReturn($shipmentId);
        $bookingMock->method('validate')->willReturn(true);

        return $bookingMock;
    }

    public function testPostShipmentSuccess()
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 201,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/InpostCourierPostShipmentSuccess.json'),
            ],
        ]);

        $inpostCourierCreateShipment = new CourierPostShipment($sessionMock);
        $shipmentId = 1234567890;
        $booking = $this->getBookingMock($shipmentId);
        $response = $inpostCourierCreateShipment->postShipment($booking);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertObjectHasAttribute('shipmentId', $response);
        $this->assertNotEmpty($response->shipmentId);
        $this->assertEquals('1234567890', $response->shipmentId);
        $this->assertObjectHasAttribute('trackingId', $response);
        $this->assertEquals($response->trackingId, '622111081631876319900026');
    }

    public function testPostShipmentFailure()
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 404,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/InpostCourierActionFailure.json'),
            ],
        ]);

        $inpostCourierCreateShipment = new CourierPostShipment($sessionMock);
        $shipmentId = 1234567890;
        $booking = $this->getBookingMock($shipmentId);
        $response = $inpostCourierCreateShipment->postShipment($booking);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertInstanceOf(Throwable::class, $response->getFirstError());
        $this->assertInstanceOf(TransportException::class, $response->getFirstError());
    }
}
