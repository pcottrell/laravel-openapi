<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type;

use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\FormatAnnotation\Format\Format;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\FormatAnnotation\Format\NumberFormat;

final class TNumber extends TNumeral
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
