<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\Formats;

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
