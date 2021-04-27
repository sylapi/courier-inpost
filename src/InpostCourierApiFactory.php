<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Inpost\InpostCourier as Courier;

class InpostCourierApiFactory
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
            new InpostCourierCreateShipment($session),
            new InpostCourierPostShipment($session),
            new InpostCourierGetLabels($session),
            new InpostCourierGetStatuses($session),
            new InpostCourierMakeShipment(),
            new InpostCourierMakeParcel(),
            new InpostCourierMakeReceiver(),
            new InpostCourierMakeSender(),
            new InpostCourierMakeBooking()
        );
    }
}
