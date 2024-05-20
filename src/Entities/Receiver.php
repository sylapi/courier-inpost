<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost\Entities;

use Rakit\Validation\Validator;
use Brick\PhoneNumber\PhoneNumber;
use Sylapi\Courier\Abstracts\Receiver as ReceiverAbstract;
use Sylapi\Courier\Contracts\Address;

class Receiver extends ReceiverAbstract
{
    private $phone;


    public function setPhone(string $phone): Address
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone(): ?string
    {
        $number = PhoneNumber::parse($this->phone, 'PL');
        return $number->formatForCallingFrom('PL');
    }

    public function validate(): bool
    {
        $rules = [
            'firstName'   => 'required',
            'surname'     => 'required',
            'countryCode' => 'required|min:2|max:2',
            'city'        => 'required',
            'zipCode'     => 'required',
            'street'      => 'required',
            'address'     => 'required',
            'email'       => 'required|email',
        ];

        $data = $this->toArray();

        $validator = new Validator();

        $validation = $validator->validate($data, $rules);
        if ($validation->fails()) {
            $this->setErrors($validation->errors()->toArray());

            return false;
        }

        return true;
    }
}
