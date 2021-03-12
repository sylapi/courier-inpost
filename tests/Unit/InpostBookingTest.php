<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Inpost\InpostBooking;

class InpostBookingTest extends PHPUnitTestCase
{
    public function testValidatorBookingHasShipmentId()
    {
        $value = '1234567890';
        $booking = new InpostBooking();
        $booking->setShipmentId($value);
        $this->assertTrue($booking->validate());
    }

    public function testValidatorBookingHasNotShipmentId()
    {
        $booking = new InpostBooking();
        $this->assertFalse($booking->validate());
    }
}
