<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Contracts\Booking;
use Sylapi\Courier\Contracts\CourierMakeBooking;

class CourierMakeBooking implements CourierMakeBooking
{
    public function makeBooking(): Booking
    {
        return new Booking();
    }
}
