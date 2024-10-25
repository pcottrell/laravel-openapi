<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral;

use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\FormatAnnotation\Format\Format;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\FormatAnnotation\Format\IntegerFormat;

final class IntegerDescriptor extends NumeralDescriptor
{
    public function format(IntegerFormat $format): self
    {
        $clone = clone $this;

        $clone->format = Format::create($format);

        return $clone;
    }

    public static function create(): self
    {
        return parent::integer();
    }
}
