<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use Sylapi\Courier\Courier;
use Sylapi\Courier\Inpost\Session;
use Sylapi\Courier\Inpost\Parameters;
use Sylapi\Courier\Inpost\SessionFactory;
use Sylapi\Courier\Inpost\Entities\Parcel;
use Sylapi\Courier\Inpost\Entities\Sender;
use Sylapi\Courier\Inpost\Entities\Booking;
use Sylapi\Courier\Inpost\CourierApiFactory;
use Sylapi\Courier\Inpost\Entities\Receiver;
use Sylapi\Courier\Inpost\Entities\Shipment;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class CourierApiFactoryTest extends PHPUnitTestCase
{
    private $parameters = [
        'token'            => 'token',
        'organization_id'  => 'password',
        'sandbox'          => true,
        'labelType'        => 'normal',
    ];

    public function testInpostSessionFactory()
    {
        $InpostSessionFactory = new SessionFactory();
        $InpostSession = $InpostSessionFactory->session(
            Parameters::create($this->parameters)
        );
        $this->assertInstanceOf(Session::class, $InpostSession);
    }

    public function testCourierFactoryCreate()
    {
        $InpostCourierApiFactory = new CourierApiFactory(new SessionFactory());
        $courier = $InpostCourierApiFactory->create($this->parameters);

        $this->assertInstanceOf(Courier::class, $courier);
        $this->assertInstanceOf(Booking::class, $courier->makeBooking());
        $this->assertInstanceOf(Parcel::class, $courier->makeParcel());
        $this->assertInstanceOf(Receiver::class, $courier->makeReceiver());
        $this->assertInstanceOf(Sender::class, $courier->makeSender());
        $this->assertInstanceOf(Shipment::class, $courier->makeShipment());
    }
}
