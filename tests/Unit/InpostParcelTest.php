<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Sylapi\Courier\Inpost\InpostParcel;

class ParcelTest extends PHPUnitTestCase
{
    public function testWidthConvertingCmToMm()
    {
        $value = rand(1, 2000);
        $parcel = new Parcel();
        $parcel->setWidth($value);
        $this->assertEquals(($value * InpostParcel::SIZE_IMPACT), $parcel->getWidth());
    }

    public function testHeighthConvertingCmToMm()
    {
        $value = rand(1, 2000);
        $parcel = new Parcel();
        $parcel->setHeight($value);
        $this->assertEquals(($value * InpostParcel::SIZE_IMPACT), $parcel->getHeight());
    }

    public function testLengthConvertingCmToMm()
    {
        $value = rand(1, 2000);
        $parcel = new Parcel();
        $parcel->setLength($value);
        $this->assertEquals(($value * InpostParcel::SIZE_IMPACT), $parcel->getLength());
    }
}
