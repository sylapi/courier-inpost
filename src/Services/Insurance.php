<?php

namespace Sylapi\Courier\Inpost\Services;

use InvalidArgumentException;

use Sylapi\Courier\Abstracts\Services\Insurance as InsuranceAbstract;

class Insurance extends InsuranceAbstract
{
    public function handle(): array
    {
        $data = $this->getRequest();
        
        if($data === null) {
            throw new InvalidArgumentException('Request is not defined');
        }

        if(!$this->getAmount()) {
            throw new InvalidArgumentException('Amount is not defined');
        }

        $data['insurance'] = $this->getAmount();

        return $data;
    }
}
