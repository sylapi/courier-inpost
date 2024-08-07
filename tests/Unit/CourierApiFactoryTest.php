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
use Sylapi\Courier\Inpost\Entities\Credentials;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class CourierApiFactoryTest extends PHPUnitTestCase
{
    public function testInpostSessionFactory()
    {
        $credentials = new Credentials();
        $credentials->setLogin('login');
        $credentials->setPassword('password');
        $credentials->setSandbox(true);
        $sessionFactory = new SessionFactory();
        $session = $sessionFactory->session(
            $credentials
        );
        $this->assertInstanceOf(Session::class, $session);
    }

    public function testCourierFactoryCreate()
    {
        $credentials = [
            'login' => 'login',
            'password' => 'password',
            'sandbox' => true,
        ];

        $courierApiFactory = new CourierApiFactory(new SessionFactory());
        $courier = $courierApiFactory->create($credentials);

        $this->assertInstanceOf(Courier::class, $courier);
        $this->assertInstanceOf(Booking::class, $courier->makeBooking());
        $this->assertInstanceOf(Parcel::class, $courier->makeParcel());
        $this->assertInstanceOf(Receiver::class, $courier->makeReceiver());
        $this->assertInstanceOf(Sender::class, $courier->makeSender());
        $this->assertInstanceOf(Shipment::class, $courier->makeShipment());
    }
}
