<?php

namespace Sylapi\Courier\Enadawca;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class ValidateDataTest extends PHPUnitTestCase
{
    private $enadawca = null;
    private $soapMock = null;

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
        'amount' => 2.10,
        'bank_number' => '29100010001000100010001000',
        'cod' => false,
        'saturday' => false,
        'custom' => [
            'gabaryt' => 'XXL',
        ],
        'references' => 'order #1234',
        'note' => 'Note'
    ];

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->soapMock = $this->getMockBuilder('SoapClient')->disableOriginalConstructor()->getMock();

        $params = [
            'accessData' => [
                'login' => 'login',
                'password' => 'password'
            ],
            'sender' => $this->address,
            'receiver' => $this->address,
            'options' => $this->options,
        ];

        $this->enadawca = new Inpost();
        $this->enadawca->initialize($params);
    }


    public function testValidateData()
    {
        $this->enadawca->setSoapClient($this->soapMock);
        $this->enadawca->validateData();

        $this->assertNull($this->enadawca->getError());
        $this->assertTrue($this->enadawca->isSuccess());
        $this->assertNotNull($this->enadawca->getResponse());
    }
}