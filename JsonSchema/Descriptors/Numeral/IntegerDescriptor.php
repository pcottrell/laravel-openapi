<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral;

use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\FormatAnnotation\IntegerFormat;
use MohammadAlavi\ObjectOrientedJSONSchema\Format;

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
