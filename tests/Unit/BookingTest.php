<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Inpost\InpostBooking;

class BookingTest extends PHPUnitTestCase
{
    public function testValidatorBookingHasShipmentId()
    {
        $value = '1234567890';
        $booking = new Booking();
        $booking->setShipmentId($value);
        $this->assertTrue($booking->validate());
    }

    public function testValidatorBookingHasNotShipmentId()
    {
        $booking = new Booking();
        $this->assertFalse($booking->validate());
    }
}
