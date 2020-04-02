<?php

namespace Sylapi\Courier\Inpost;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class GetLabelTest extends PHPUnitTestCase
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
        'amount' => 2.10,
        'bank_number' => '29100010001000100010001000',
        'cod' => false,
        'saturday' => false,
        'references' => 'order #1234',
        'note' => 'Note',
        'custom' => [
            'gabaryt' => 'XXL',
        ]
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

        $this->inpost = new Inpost();
        $this->inpost->initialize($params);
    }

    public function testGetLabelTestSuccess()
    {
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');
        $response = $this->request->send();

        $this->assertInstanceOf('Omnipay\Mollie\Message\CompletePurchaseResponse', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isOpen());
        $this->assertTrue($response->isPaid());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('tr_Qzin4iTWrU', $response->getTransactionReference());
    }

    public function testGetLabelTestFailure()
    {
        $localXml = file_get_contents(__DIR__ . '/Mock/getPrintForParcelFailure.xml');

        $this->soapMock->expects($this->any())->method('__call')->will($this->returnValue(
            simplexml_load_string($localXml, 'SimpleXMLElement', LIBXML_NOCDATA))
        );


        $this->enadawca->setSoapClient($this->soapMock);
        $this->enadawca->GetLabel();

        $this->assertNotNull($this->enadawca->getError());
        $this->assertFalse($this->enadawca->isSuccess());
        $this->assertNull($this->enadawca->getResponse());
    }
}