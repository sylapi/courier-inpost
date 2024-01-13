<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use Sylapi\Courier\Inpost\Entities\Booking;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;


class BookingTest extends PHPUnitTestCase
{
    public function testValidatorBookingHasShipmentId()
    {
        $value = '1234567890';
        $booking = new Booking();
        $booking->setShipmentId($value);
        $this->assertTrue($booking->validate());
    }
}
