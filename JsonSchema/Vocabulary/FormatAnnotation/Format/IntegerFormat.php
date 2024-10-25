<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\FormatAnnotation\Format;

enum IntegerFormat: string implements DefinedFormat
{
    /** signed 32 bits */
    case INT32 = 'int32';

    /** signed 64 bits (a.k.a. long) */
    case INT64 = 'int64';

    public function value(): string
    {
        return $this->value;
    }
}