<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost\Entities;

use Rakit\Validation\Validator;
use Sylapi\Courier\Abstracts\Booking as BookingAbstract;

class Booking extends BookingAbstract
{

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
