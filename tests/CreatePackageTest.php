<?php

namespace Sylapi\Courier\Inpost;

use PHPUnit\Framework\TestCase;

class CreatePackageTest extends TestCase
{
    private $inpost = null;

    private $address = [
        'name' => 'Name Username',
        'company' => '',
        'street' => 'Street 1',
        'postcode' => '12-123',
        'city' => 'Warszawa',
        'country' => 'PL',
        'phone' => '600600600',
        'email' => 'name@example.com'
    ];

    private $options = [
        'weight' => 3.00,
        'width' => 30.00,
        'height' => 50.00,
        'depth' => 10.00,
        'amount' => 2390.10,
        'currency' => 'PLN',
        'cod' => true,
        'references' => 'order #4567',
        'note' => 'Note',
        'custom' => [
            'is_non_standard' => true,
            'service' => 'inpost_locker_standard',
            'external_customer_id' => 12345,
            'target_point' => 'KRA01N'
        ],
    ];

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $params = [
            'accessData' => [
                'token' => 'token',
                'login' => 'login'
            ],
            'sender' => $this->address,
            'receiver' => $this->address,
            'options' => $this->options,
        ];

        $this->inpost = new Inpost();
        $this->inpost->initialize($params);
    }


    public function testCreatePackageSuccess()
    {
        $this->inpost->setUri(__DIR__ . '/Mock/createShipmentSuccess.txt');

        $this->inpost->CreatePackage();

        $this->assertNull($this->inpost->getError());
        $this->assertTrue($this->inpost->isSuccess());
        $this->assertNotNull($this->inpost->getResponse());
    }


    public function testCreatePackageFailure()
    {
        $this->inpost->setUri(__DIR__ . '/Mock/createShipmentFailure.txt');

        $this->inpost->CreatePackage();

        $this->assertNotNull($this->inpost->getError());
        $this->assertFalse($this->inpost->isSuccess());
        $this->assertNull($this->inpost->getResponse());
    }
}