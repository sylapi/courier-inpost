<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost\Entities;

use Rakit\Validation\Validator;
use Sylapi\Courier\Abstracts\Parcel as ParcelAbstract;

class Parcel extends ParcelAbstract
{
    public function validate(): bool
    {
        $rules = [
            'weight' => 'required|numeric|min:0.01',
        ];
        $data = [
            'weight' => $this->getWeight(),
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
