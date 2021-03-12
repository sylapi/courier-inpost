<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use Rakit\Validation\Validator;
use Sylapi\Courier\Abstracts\Shipment;

class InpostShipment extends Shipment
{
    public function getQuantity(): int
    {
        return 1;
    }

    public function validate(): bool
    {
        $rules = [
            'quantity' => 'required|min:1|max:1',
            'parcel'   => 'required',
            'sender'   => 'required',
            'receiver' => 'required',
        ];

        $data = [
            'quantity' => $this->getQuantity(),
            'parcel'   => $this->getParcel(),
            'sender'   => $this->getSender(),
            'receiver' => $this->getReceiver(),
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
