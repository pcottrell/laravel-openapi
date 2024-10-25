<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\FormatAnnotation;

use MohammadAlavi\ObjectOrientedJSONSchema\DefinedFormat;

enum NumberFormat: string implements DefinedFormat
{
    case FLOAT = 'float';

    case DOUBLE = 'double';

    public function value(): string
    {
        return $this->value;
    }
}
