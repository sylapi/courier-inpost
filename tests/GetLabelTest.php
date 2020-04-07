<?php

namespace Sylapi\Courier\Inpost;

use PHPUnit\Framework\TestCase;

class GetLabelTest extends TestCase
{
    private $inpost = null;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $params = [
            'accessData' => [
                'token' => 'token',
                'login' => 'login'
            ],
            'custom_id' => 1,
            'tracking_id' => 1
        ];

        $this->inpost = new Inpost();
        $this->inpost->initialize($params);
    }


    public function testGetLabelSuccess()
    {
        $this->inpost->setUri(__DIR__ . '/Mock/getLabelSuccess.txt');

        $this->inpost->GetLabel();

        $this->assertNull($this->inpost->getError());
        $this->assertTrue($this->inpost->isSuccess());
        $this->assertNotNull($this->inpost->getResponse());
    }


    public function testGetLabelFailure()
    {
        $this->inpost->setUri(__DIR__ . '/Mock/getLabelFailure.txt');

        $this->inpost->GetLabel();

        $this->assertNotNull($this->inpost->getError());
        $this->assertFalse($this->inpost->isSuccess());
        $this->assertNull($this->inpost->getResponse());
    }
}