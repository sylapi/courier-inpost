<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Sylapi\Courier\Abstracts\Receiver;

class InpostReceiver extends Receiver
{
    public function validate(): bool
    {
        return true;
    }
}
