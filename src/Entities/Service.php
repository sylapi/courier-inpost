<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost\Entities;

use Sylapi\Courier\Abstracts\Service as ServiceAbstract;

class Service extends ServiceAbstract
{

    public function handle(): array
    {
        return $this->all();
    }
    public function validate(): bool
    {
        return true;
    }
}
