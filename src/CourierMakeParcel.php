<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Contracts\CourierMakeParcel as CourierMakeParcelContract;
use Sylapi\Courier\Contracts\Parcel as ParcelContract;
use Sylapi\Courier\Inpost\Entities\Parcel;

class CourierMakeParcel implements CourierMakeParcelContract
{
    public function makeParcel(): ParcelContract
    {
        return new Parcel();
    }
}

