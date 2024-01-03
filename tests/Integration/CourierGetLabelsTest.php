<?php

namespace Sylapi\Courier\Inpost\Tests;

use Throwable;
use Sylapi\Courier\Contracts\Label;
use Sylapi\Courier\Inpost\CourierGetLabels;
use Sylapi\Courier\Inpost\Entities\LabelType;
use Sylapi\Courier\Exceptions\TransportException;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Inpost\Tests\Helpers\SessionTrait;
use Sylapi\Courier\Inpost\Responses\Label as LabelResponse;

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

        $labelTypeMock = $this->createMock(LabelType::class);
        $response = $inpostCourierGetLabels->getLabel('123', $labelTypeMock);
        $this->assertInstanceOf(LabelResponse::class, $response);
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
        $this->expectException(TransportException::class);

        $courierGetLabels = new CourierGetLabels($sessionMock);
        $labelTypeMock = $this->createMock(LabelType::class);
        $courierGetLabels->getLabel('123', $labelTypeMock);
    }
}
