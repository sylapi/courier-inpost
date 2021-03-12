<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Courier;
use Sylapi\Courier\Inpost\InpostBooking;
use Sylapi\Courier\Inpost\InpostCourierApiFactory;
use Sylapi\Courier\Inpost\InpostParameters;
use Sylapi\Courier\Inpost\InpostParcel;
use Sylapi\Courier\Inpost\InpostReceiver;
use Sylapi\Courier\Inpost\InpostSender;
use Sylapi\Courier\Inpost\InpostSession;
use Sylapi\Courier\Inpost\InpostSessionFactory;
use Sylapi\Courier\Inpost\InpostShipment;

class InpostCourierApiFactoryTest extends PHPUnitTestCase
{
    private $parameters = [
        'token'           => 'token',
        'organization_id'  => 'password',
        'sandbox'         => true,
        'labelType'       => 'normal',
    ];

    public function testInpostSessionFactory()
    {
        $InpostSessionFactory = new InpostSessionFactory();
        $InpostSession = $InpostSessionFactory->session(
            InpostParameters::create($this->parameters)
        );
        $this->assertInstanceOf(InpostSession::class, $InpostSession);
    }

    public function testCourierFactoryCreate()
    {
        $InpostCourierApiFactory = new InpostCourierApiFactory(new InpostSessionFactory());
        $courier = $InpostCourierApiFactory->create($this->parameters);

        $this->assertInstanceOf(Courier::class, $courier);
        $this->assertInstanceOf(InpostBooking::class, $courier->makeBooking());
        $this->assertInstanceOf(InpostParcel::class, $courier->makeParcel());
        $this->assertInstanceOf(InpostReceiver::class, $courier->makeReceiver());
        $this->assertInstanceOf(InpostSender::class, $courier->makeSender());
        $this->assertInstanceOf(InpostShipment::class, $courier->makeShipment());
    }
}
