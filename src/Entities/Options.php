<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost\Entities;

use Sylapi\Courier\Abstracts\Options as OptionsAbstract;

class Options extends OptionsAbstract
{
    const DEFAULT_SERVICE = 'inpost_courier_standard';

    private string $service = self::DEFAULT_SERVICE;

    public function setService(string $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getService()
    {
        return  $this->service;
    }

    public function validate(): bool
    {
        return true;
    }
}
