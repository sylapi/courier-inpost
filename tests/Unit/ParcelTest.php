<?php

namespace Sylapi\Courier\Inpost\Tests\Unit;

use Sylapi\Courier\Inpost\Entities\Parcel;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class ParcelTest extends PHPUnitTestCase
{
    public function testWidthConvertingCmToMm()
    {
        $value = rand(1, 2000);
        $parcel = new Parcel();
        $parcel->setWidth($value);
        $this->assertEquals(($value * Parcel::SIZE_IMPACT), $parcel->getWidth());
    }

    public function testHeighthConvertingCmToMm()
    {
        $value = rand(1, 2000);
        $parcel = new Parcel();
        $parcel->setHeight($value);
        $this->assertEquals(($value * Parcel::SIZE_IMPACT), $parcel->getHeight());
    }

    public function testLengthConvertingCmToMm()
    {
        $value = rand(1, 2000);
        $parcel = new Parcel();
        $parcel->setLength($value);
        $this->assertEquals(($value * Parcel::SIZE_IMPACT), $parcel->getLength());
    }
}
