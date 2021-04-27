<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Courier;
use Sylapi\Courier\Contracts\CourierCreateShipment;
use Sylapi\Courier\Contracts\CourierGetLabels;
use Sylapi\Courier\Contracts\CourierGetStatuses;
use Sylapi\Courier\Contracts\CourierMakeBooking;
use Sylapi\Courier\Contracts\CourierMakeParcel;
use Sylapi\Courier\Contracts\CourierMakeReceiver;
use Sylapi\Courier\Contracts\CourierMakeSender;
use Sylapi\Courier\Contracts\CourierMakeShipment;
use Sylapi\Courier\Contracts\CourierPostShipment;
use Sylapi\Courier\Contracts\Response as ResponseContract;

class InpostCourier extends Courier
{
    private $createShipment;

    public function __construct(
        CourierCreateShipment $createShipment,
        CourierPostShipment $postShipment,
        CourierGetLabels $getLabels,
        CourierGetStatuses $getStatuses,
        CourierMakeShipment $makeShipment,
        CourierMakeParcel $makeParcel,
        CourierMakeReceiver $makeReceiver,
        CourierMakeSender $makeSender,
        CourierMakeBooking $makeBooking
    ) {
        parent::__construct(
            $createShipment,
            $postShipment,
            $getLabels,
            $getStatuses,
            $makeShipment,
            $makeParcel,
            $makeReceiver,
            $makeSender,
            $makeBooking
        );

        $this->createShipment = $createShipment;
    }

    public function getTrackingId(string $shipmentId): ResponseContract
    {
        return $this->createShipment->getTrackingId($shipmentId);
    }
}
