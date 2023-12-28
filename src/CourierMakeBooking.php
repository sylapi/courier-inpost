<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Contracts\Booking;
use Sylapi\Courier\Contracts\Booking as BookingContract;
use Sylapi\Courier\Contracts\CourierMakeBooking as CourierMakeBookingContract;

class CourierMakeBooking implements CourierMakeBookingContract
{
    public function makeBooking(): BookingContract
    {
        return new Booking();
    }
}

