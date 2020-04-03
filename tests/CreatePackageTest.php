<?php

namespace Sylapi\Courier\Inpost;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class CreatePackageTest extends PHPUnitTestCase
{
    private $inpost = null;
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


        //$this->soapMock = $this->getMockBuilder('SoapClient')->disableOriginalConstructor()->getMock();

        $params = [
            'accessData' => [
                'login' => 'login',
                'password' => 'password'
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
        $this->setMockHttpResponse('CreateShipmentSuccess.txt');
        $response = $this->request->send();

        $this->assertInstanceOf('Sylapi\Courier\Inpost\CreatePackage', $response);
        $this->assertNull($response->getError());
        $this->assertTrue($response->isSuccess());
        $this->assertNotNull($response->getResponse());
    }

/*
    public function testCreatePackageFailure()
    {
        $localXml = file_get_contents(__DIR__ . '/Mock/addShippmentFailure.xml');

        $this->soapMock->expects($this->any())->method('__call')->will($this->returnValue(
            simplexml_load_string($localXml, 'SimpleXMLElement', LIBXML_NOCDATA))
        );

        $this->enadawca->setSoapClient($this->soapMock);
        $this->enadawca->CreatePackage();

        $this->assertNotNull($this->enadawca->getError());
        $this->assertFalse($this->enadawca->isSuccess());
        $this->assertNull($this->enadawca->getResponse());
    }
*/
}