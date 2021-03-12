<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Contracts\CourierMakeSender;
use Sylapi\Courier\Contracts\Sender;

class InpostCourierMakeSender implements CourierMakeSender
{
    public function makeSender(): Sender
    {
        return new InpostSender();
    }
}
