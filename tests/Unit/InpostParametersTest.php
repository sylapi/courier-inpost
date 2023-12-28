<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Exceptions\ValidateException;
use Sylapi\Courier\Inpost\InpostParameters;

class ParametersTest extends PHPUnitTestCase
{
    public function testHasProperty()
    {
        $parameters = InpostParameters::create([
            'test' => 1,
        ]);

        $this->assertTrue($parameters->hasProperty('test'));
    }

    public function testNotHasProperty()
    {
        $parameters = InpostParameters::create([
            'test1' => 2,
        ]);

        $this->assertFalse($parameters->hasProperty('test'));
    }

    public function testHasPropertyLabelType()
    {
        $value = 'label_value';
        $parameters = InpostParameters::create([
            'labelType' => $value,
        ]);

        $this->assertEquals($value, $parameters->getLabelType());
    }

    public function testNotHasPropertyLabelType()
    {
        $parameters = InpostParameters::create([
            'test1' => 2,
        ]);

        $this->assertEquals(InpostParameters::DEFAULT_LABEL_TYPE, $parameters->getLabelType());
    }

    public function testHasPropertyService()
    {
        $value = 'service_value';
        $parameters = InpostParameters::create([
            'service' => $value,
        ]);

        $this->assertEquals($value, $parameters->getService());
    }

    public function testNotHasPropertyDispatchPoint()
    {
        $this->expectException(ValidateException::class);
        $parameters = InpostParameters::create([
            'test1' => 2,
        ]);
        $parameters->getDispatchPoint();
    }

    public function testHasPropertyDispatchPointId()
    {
        $value = 123456;
        $parameters = InpostParameters::create([
            'dispatch_point_id' => $value,
        ]);

        $this->assertEquals(['dispatch_point_id' => $value], $parameters->getDispatchPoint());
    }

    public function testHasPropertyDispatchPoint()
    {
        $value = [
            'street'          => 'Street',
            'building_number' => '2',
            'city'            => 'City',
            'post_code'       => '11-222',
            'country_code'    => 'PL',
            'service'         => 'inpost_courier_standard',
        ];

        $parameters = InpostParameters::create([
            'dispatch_point' => $value,
        ]);

        $this->assertEquals(['address' => $value], $parameters->getDispatchPoint());
    }

    public function testHasBothDispatchPointProperties()
    {
        $valueDispatchPointId = 123456;
        $valueDispatchPoint = [
            'street'          => 'Street',
            'building_number' => '2',
            'city'            => 'City',
            'post_code'       => '11-222',
            'country_code'    => 'PL',
            'service'         => 'inpost_courier_standard',
        ];

        $parameters = InpostParameters::create([
            'dispatch_point'    => $valueDispatchPoint,
            'dispatch_point_id' => $valueDispatchPointId,
        ]);

        $this->assertEquals(['dispatch_point_id' => $valueDispatchPointId], $parameters->getDispatchPoint());
    }
}
