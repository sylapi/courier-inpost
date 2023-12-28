<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Contracts\CourierMakeShipment;
use Sylapi\Courier\Contracts\Shipment;

class CourierMakeShipment implements CourierMakeShipment
{
    public function makeShipment(): Shipment
    {
        return new Shipment();
    }
}
