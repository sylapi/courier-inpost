<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost\Entities;

use Rakit\Validation\Validator;
use Sylapi\Courier\Abstracts\Booking as BookingAbstract;

class Booking extends BookingAbstract
{
    private array $dispatchPoint;

    public function setDispatchPoint(array $dispatchPoint): self
    {
        $this->dispatchPoint = $dispatchPoint;

        return $this;
    }

    // public function getDispatchPoint()
    // {
    //     if ($this->hasProperty('dispatch_point_id')) {
    //         return [
    //             'dispatch_point_id' => $this->dispatch_point_id,
    //         ];
    //     } elseif ($this->hasProperty('dispatch_point')) {
    //         return [
    //             'address' => $this->dispatch_point,
    //         ];
    //     } else {
    //         throw new ValidateException('Dispatch point is not defined');
    //     }
    // }

    public function getDispatchPoint(): ?array
    {
        return $this->dispatchPoint;
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
