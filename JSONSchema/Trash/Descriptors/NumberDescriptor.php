<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptors;

use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\Formats\NumberFormat;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Format;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptors\NumeralDescriptor;

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
