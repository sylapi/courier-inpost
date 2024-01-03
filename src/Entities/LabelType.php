<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost\Entities;

use Sylapi\Courier\Abstracts\LabelType as LabelTypeAbstract;

class LabelType extends LabelTypeAbstract
{
    const DEFAULT_LABEL_FORMAT = 'Pdf';
    const DEFAULT_LABEL_TYPE = 'normal';

    private string $labelType = self::DEFAULT_LABEL_TYPE;
    private string $labelFormat = self::DEFAULT_LABEL_FORMAT;

    public function getLabelType(): string
    {
        return  $this->labelType;
    }

    public function getLabelFormat(): string
    {
        return  $this->labelFormat;
    }

    public function validate(): bool
    {
        return true;
    }
}
