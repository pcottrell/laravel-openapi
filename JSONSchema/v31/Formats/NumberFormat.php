<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Formats;

use MohammadAlavi\ObjectOrientedJSONSchema\Formats\DefinedFormat;

enum NumberFormat: string implements DefinedFormat
{
    case FLOAT = 'float';

    case DOUBLE = 'double';

    public function value(): string
    {
        return $this->value;
    }
}
