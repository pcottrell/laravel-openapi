<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\FormatAnnotation\Format;

enum NumberFormat: string implements DefinedFormat
{
    case FLOAT = 'float';

    case DOUBLE = 'double';

    public function value(): string
    {
        return $this->value;
    }
}
