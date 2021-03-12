<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Inpost\InpostParcel;

class InpostParcelTest extends PHPUnitTestCase
{
    public function testWidthConvertingCmToMm()
    {
        $value = rand(1,2000);
        $parcel = new InpostParcel();
        $parcel->setWidth($value);
        $this->assertEquals(($value * InpostParcel::SIZE_IMPACT),  $parcel->getWidth());
    }

    public function testHeighthConvertingCmToMm()
    {
        $value = rand(1,2000);
        $parcel = new InpostParcel();
        $parcel->setHeight($value);
        $this->assertEquals(($value * InpostParcel::SIZE_IMPACT),  $parcel->getHeight());
    }

    public function testLengthConvertingCmToMm()
    {
        $value = rand(1,2000);
        $parcel = new InpostParcel();
        $parcel->setLength($value);
        $this->assertEquals(($value * InpostParcel::SIZE_IMPACT),  $parcel->getLength());
    }
}
