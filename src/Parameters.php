<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost;

use ArrayObject;
use Sylapi\Courier\Exceptions\ValidateException;

class Parameters extends ArrayObject
{
    const DEFAULT_LABEL_FORMAT = 'Pdf';
    const DEFAULT_LABEL_TYPE = 'normal';
    const DEFAULT_SERVICE = 'inpost_courier_standard';

    public static function create(array $parameters): self
    {
        return new self($parameters, ArrayObject::ARRAY_AS_PROPS);
    }

    public function getLabelType()
    {
        return  ($this->hasProperty('labelType')) ? $this->labelType : self::DEFAULT_LABEL_TYPE;
    }

    public function getService()
    {
        return  ($this->hasProperty('service')) ? $this->service : self::DEFAULT_SERVICE;
    }

    public function getDispatchPoint()
    {
        if ($this->hasProperty('dispatch_point_id')) {
            return [
                'dispatch_point_id' => $this->dispatch_point_id,
            ];
        } elseif ($this->hasProperty('dispatch_point')) {
            return [
                'address' => $this->dispatch_point,
            ];
        } else {
            throw new ValidateException('Dispatch point is not defined');
        }
    }

    public function hasProperty(string $name)
    {
        return property_exists($this, $name);
    }
}
