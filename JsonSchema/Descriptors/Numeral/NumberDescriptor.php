<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral;

use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\FormatAnnotation\NumberFormat;
use MohammadAlavi\ObjectOrientedJSONSchema\Format;

final class NumberDescriptor extends NumeralDescriptor
{
    public function format(NumberFormat $format): self
    {
        $clone = clone $this;

        $clone->format = Format::create($format);

        return $clone;
    }

    public static function create(): self
    {
        return parent::number();
    }
}
