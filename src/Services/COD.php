<?php

namespace Sylapi\Courier\Gls\Services;

use InvalidArgumentException;

use Sylapi\Courier\Abstracts\Services\COD as CODAbstract;

class COD extends CODAbstract
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

        $data['cod'] = $this->getAmount();

        return $data;
    }
}
