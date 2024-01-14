<?php

namespace Sylapi\Courier\Inpost\Services;

use InvalidArgumentException;

use Sylapi\Courier\Abstracts\Services\PickupPoint as PickupPointAbstract;

class PickupPoint extends PickupPointAbstract
{
    public function handle(): array
    {
        $data = $this->getRequest();
        
        if($data === null) {
            throw new InvalidArgumentException('Request is not defined');
        }

        if(!$this->getPickupId()) {
            throw new InvalidArgumentException('PickupId is not defined');
        }

        $data['custom_attributes']['target_point'] = $this->getPickupId();

        return $data;
    }
}
