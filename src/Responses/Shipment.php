<?php

namespace Sylapi\Courier\Inpost\Responses;
use Sylapi\Courier\Inpost\Entities\Booking;
use Sylapi\Courier\Responses\Shipment as ShipmentResponse;
use Sylapi\Courier\Contracts\Response as ResponseContract;

class Shipment extends ShipmentResponse
{
    private $trackingId;

    public function setTrackingId(string $trackingId): ResponseContract
    {
        $this->trackingId = $trackingId;

        return $this;
    }

    public function getTrackingId(): ?string
    {
        return $this->trackingId;
    }

    public function getBooking() : ?Booking
    {

        if(!$this->getResponse()) {
            return null;
        }

        $booking = new Booking();
        $booking->setShipmentId($this->getResponse()->getShipmentId());

        return $booking;

    }
}
