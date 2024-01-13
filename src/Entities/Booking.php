<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost\Entities;

use Rakit\Validation\Validator;
use Sylapi\Courier\Exceptions\ValidateException;
use Sylapi\Courier\Abstracts\Booking as BookingAbstract;

class Booking extends BookingAbstract
{
    protected string $dispatchPointId;
    protected string $dispatchPointAddress;

    public function setDispatchPointId(string $dispatchPointId): self
    {
        $this->dispatchPointId = $dispatchPointId;

        return $this;
    }

    public function setDispatchPointAddress(string $dispatchPointAddress): self
    {
        $this->dispatchPointAddress = $dispatchPointAddress;

        return $this;
    }

    public function getDispatchPoint(): array 
    {
        if ($this->dispatchPointId) {
            return [
                'dispatch_point_id' => $this->dispatchPointId,
            ];
        } elseif ($this->dispatchPointAddress) {
            return [
                'address' => $this->dispatchPointAddress,
            ];
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
