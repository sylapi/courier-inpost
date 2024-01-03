<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost\Entities;

use Sylapi\Courier\Abstracts\Parcel as ParcelAbstract;

class Parcel extends ParcelAbstract
{
    const SIZE_IMPACT = 10;

    /**
     * Convert: cm -> mm.
     */
    public function getHeight(): ?int
    {
        $value = parent::getHeight();

        return is_numeric($value) ? (int) ($value * self::SIZE_IMPACT) : null;
    }

    /**
     * Convert: cm -> mm.
     */
    public function getWidth(): ?int
    {
        $value = parent::getWidth();

        return is_numeric($value) ? (int) ($value * self::SIZE_IMPACT) : null;
    }

    /**
     * Convert: cm -> mm.
     */
    public function getLength(): ?int
    {
        $value = parent::getLength();

        return is_numeric($value) ? (int) ($value * self::SIZE_IMPACT) : null;
    }

    public function validate(): bool
    {
        return true;
    }
}
