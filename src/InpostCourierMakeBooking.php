<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Contracts\Booking;
use Sylapi\Courier\Contracts\CourierMakeBooking;

class InpostCourierMakeBooking implements CourierMakeBooking
{
    public function makeBooking(): Booking
    {
        return new InpostBooking();
    }
}
