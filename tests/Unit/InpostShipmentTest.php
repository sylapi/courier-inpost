<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Inpost\InpostParcel;
use Sylapi\Courier\Inpost\InpostReceiver;
use Sylapi\Courier\Inpost\InpostSender;
use Sylapi\Courier\Inpost\InpostShipment;

class InpostShipmentTest extends PHPUnitTestCase
{
    public function testNumberOfPackagesIsAlwaysEqualTo1()
    {
        $parcel = new InpostParcel();
        $shipment = new InpostShipment();
        $shipment->setParcel($parcel);
        $shipment->setParcel($parcel);

        $this->assertEquals(1, $shipment->getQuantity());
    }

    public function testShipmentValidate()
    {
        $receiver = new InpostReceiver();
        $sender = new InpostSender();
        $parcel = new InpostParcel();

        $shipment = new InpostShipment();
        $shipment->setSender($sender)
            ->setReceiver($receiver)
            ->setParcel($parcel);

        $this->assertIsBool($shipment->validate());
        $this->assertIsBool($shipment->getReceiver()->validate());
        $this->assertIsBool($shipment->getSender()->validate());
        $this->assertIsBool($shipment->getParcel()->validate());
    }
}
