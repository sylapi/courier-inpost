<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost\Entities;

use Rakit\Validation\Validator;
use Sylapi\Courier\Exceptions\ValidateException;
use Sylapi\Courier\Abstracts\Booking as BookingAbstract;

class Booking extends BookingAbstract
{
    protected array $dispatchPointAddress;



    public function setDispatchPointAddress(array $dispatchPointAddress): self
    {
        $this->dispatchPointAddress = $dispatchPointAddress;

        return $this;
    }

    public function getDispatchPointAddress(): array 
    {
        if ($this->dispatchPointAddress) {
            return $this->dispatchPointAddress;
        } else {
            throw new ValidateException('Dispatch point is not defined');
        }
    }

    public function validate(): bool
    {
        $rules = [
            'shipmentId' => 'required',
        ];
        $data = [
            'shipmentId' => $this->getShipmentId(),
        ];

        $validator = new Validator();

        $validation = $validator->validate($data, $rules);
        if ($validation->fails()) {
            $this->setErrors($validation->errors()->toArray());

            return false;
        }

        return true;
    }
}
