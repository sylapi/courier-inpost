<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

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
use Sylapi\Courier\Courier as CourierBase;
use Sylapi\Courier\Inpost\CourierCreateShipment as InpostCourierCreateShipment;
use Sylapi\Courier\Inpost\Entities\Options;

class Courier extends CourierBase
{
    public function __construct(
        /**
        * @var InpostCourierCreateShipment $createShipment
        */
        private CourierCreateShipment $createShipment,
        CourierPostShipment $postShipment,
        CourierGetLabels $getLabels,
        CourierGetStatuses $getStatuses,
        CourierMakeShipment $makeShipment,
        CourierMakeParcel $makeParcel,
        CourierMakeReceiver $makeReceiver,
        CourierMakeSender $makeSender,
        CourierMakeService $makeService,
        CourierMakeOptions $makeOptions,
        CourierMakeBooking $makeBooking,
        CourierMakeLabelType $makeLabelType
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
            $makeService,
            $makeOptions,
            $makeBooking,
            $makeLabelType
        );


        $this->createShipment = $createShipment;
    }

    public function getTrackingId(string $shipmentId): ResponseContract
    {   
        return $this->createShipment->getTrackingId($shipmentId);
    }

    public function getShipmentId(string $trackingId): ResponseContract
    {
        return $this->createShipment->getShipmentId($trackingId);
    }
}
