<?php

namespace Sylapi\Courier\Inpost;

use PHPUnit\Framework\TestCase;

class DeletePackageTest extends TestCase
{
    private $inpost = null;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $params = [
            'accessData' => [
                'token' => 'token',
                'login' => 'login',
            ],
            'custom_id' => 1,
        ];

        $this->inpost = new Inpost();
        $this->inpost->initialize($params);
    }

    public function testDeletePackageSuccess()
    {
        $this->inpost->setUri(__DIR__.'/Mock/deleteShipmentSuccess.txt');

        $this->inpost->DeletePackage();

        $this->assertNull($this->inpost->getError());
        $this->assertTrue($this->inpost->isSuccess());
        $this->assertNotNull($this->inpost->getResponse());
    }

    public function testDeletePackageFailure()
    {
        $this->inpost->setUri(__DIR__.'/Mock/deleteShipmentFailure.txt');

        $this->inpost->DeletePackage();

        $this->assertNotNull($this->inpost->getError());
        $this->assertFalse($this->inpost->isSuccess());
        $this->assertNull($this->inpost->getResponse());
    }
}
