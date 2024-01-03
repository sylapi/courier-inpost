<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Inpost\Courier;
use Sylapi\Courier\Inpost\Entities\Credentials;


class CourierApiFactory
{
    private $inpostSessionFactory;

    public function __construct(SessionFactory $inpostSessionFactory)
    {
        $this->inpostSessionFactory = $inpostSessionFactory;
    }

    public function create(array $credentials): Courier
    {
        $credentials = Credentials::from($credentials);

        $session = $this->inpostSessionFactory
                    ->session($credentials);

        return new Courier(
            new CourierCreateShipment($session),
            new CourierPostShipment($session),
            new CourierGetLabels($session),
            new CourierGetStatuses($session),
            new CourierMakeShipment(),
            new CourierMakeParcel(),
            new CourierMakeReceiver(),
            new CourierMakeSender(),
            new CourierMakeService(),
            new CourierMakeOptions(),
            new CourierMakeBooking(),
            new CourierMakeLabelType(),
        );
    }
}
