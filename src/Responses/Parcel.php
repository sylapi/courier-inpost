<?php

namespace Sylapi\Courier\Inpost\Responses;

use Sylapi\Courier\Responses\Parcel as ParcelResponse;
use Sylapi\Courier\Contracts\Response as ResponseContract;

class Parcel extends ParcelResponse
{
    private string $trackingId;
    private string $trackingBarcode;
    private string $trackingUrl;

    public function setTrackingId(string $trackingId): ResponseContract
    {
        $this->trackingId = $trackingId;

        return $this;
    }

    public function getTrackingId(): ?string
    {
        return $this->trackingId;
    }

    public function setTrackingBarcode(string $trackingBarcode): ResponseContract
    {
        $this->trackingBarcode = $trackingBarcode;

        return $this;
    }

    public function getTrackingBarcode(): ?string
    {
        return $this->trackingBarcode;
    }

    public function setTrackingUrl(string $trackingUrl): ResponseContract
    {
        $this->trackingUrl = $trackingUrl;

        return $this;
    }

    public function getTrackingUrl(): ?string
    {
        return $this->trackingUrl;
    }
}
