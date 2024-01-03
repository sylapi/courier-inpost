<?php

namespace Sylapi\Courier\Inpost\Tests;

use Throwable;
use Sylapi\Courier\Contracts\Label;
use Sylapi\Courier\Inpost\CourierGetLabels;
use Sylapi\Courier\Exceptions\TransportException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Inpost\Tests\Helpers\SessionTrait;

class CourierGetLabelsTest extends PHPUnitTestCase
{
    use SessionTrait;

    public function testGetLabelSuccess()
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 200,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/InpostCourierGetLabelSuccess.json'),
            ],
        ]);

        $inpostCourierGetLabels = new CourierGetLabels($sessionMock);

        $response = $inpostCourierGetLabels->getLabel('123');
        $this->assertEquals($response, 'JVBERi0xLjcKOCAwIG9iago8PCAv');
    }

    public function testGetLabelFailure()
    {
        $sessionMock = $this->getSessionMock([
            [
                'code'   => 404,
                'header' => [],
                'body'   => file_get_contents(__DIR__.'/Mock/InpostCourierActionFailure.json'),
            ],
        ]);

        $inpostCourierGetLabels = new CourierGetLabels($sessionMock);
        $response = $inpostCourierGetLabels->getLabel('123');
        $this->assertInstanceOf(Label::class, $response);
        $this->assertEquals(null, (string) $response);
        $this->assertInstanceOf(Throwable::class, $response->getFirstError());
        $this->assertInstanceOf(TransportException::class, $response->getFirstError());
    }
}
