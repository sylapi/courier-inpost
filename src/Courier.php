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

class Courier extends CourierBase
{
    public function __construct(
        private CourierCreateShipment $createShipment,
        private CourierPostShipment $postShipment,
        private CourierGetLabels $getLabels,
        private CourierGetStatuses $getStatuses,
        private CourierMakeShipment $makeShipment,
        private CourierMakeParcel $makeParcel,
        private CourierMakeReceiver $makeReceiver,
        private CourierMakeSender $makeSender,
        private CourierMakeService $makeService,
        private CourierMakeOptions $makeOptions,
        private CourierMakeBooking $makeBooking,
        private CourierMakeLabelType $makeLabelType
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

        /**
         * @var InpostCourierCreateShipment $createShipment
         */
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
