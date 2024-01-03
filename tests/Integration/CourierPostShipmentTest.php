<?php

namespace Sylapi\Courier\Inpost\Tests\Integration;

use Throwable;
use Sylapi\Courier\Inpost\Responses\Parcel as ParcelResponse;
use Sylapi\Courier\Inpost\Entities\Booking;
use Sylapi\Courier\Inpost\CourierPostShipment;
use Sylapi\Courier\Exceptions\TransportException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Inpost\Tests\Helpers\SessionTrait;

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

        $this->assertInstanceOf(ParcelResponse::class, $response);
        $this->assertNotEmpty($response->getShipmentId());
        $this->assertEquals('1234567890', $response->getShipmentId());
        $this->assertEquals($response->getTrackingId(), '622111081631876319900026');
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
        $this->expectException(TransportException::class);
        
        $courierCreateShipment = new CourierPostShipment($sessionMock);
        $shipmentId = 1234567890;
        $booking = $this->getBookingMock($shipmentId);
        $courierCreateShipment->postShipment($booking);
    }
}
