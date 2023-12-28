<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Inpost\InpostCourier as Courier;

class CourierApiFactory
{
    private $inpostSessionFactory;

    public function __construct(InpostSessionFactory $inpostSessionFactory)
    {
        $this->inpostSessionFactory = $inpostSessionFactory;
    }

    public function create(array $parameters): Courier
    {
        $session = $this->inpostSessionFactory
                    ->session(InpostParameters::create($parameters));

        return new Courier(
            new CourierCreateShipment($session),
            new CourierPostShipment($session),
            new CourierGetLabels($session),
            new CourierGetStatuses($session),
            new CourierMakeShipment(),
            new CourierMakeParcel(),
            new CourierMakeReceiver(),
            new CourierMakeSender(),
            new CourierMakeBooking()
        );
    }
}
