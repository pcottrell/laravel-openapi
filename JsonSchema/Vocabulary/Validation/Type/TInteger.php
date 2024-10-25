<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type;

use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\FormatAnnotation\Format\Format;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\FormatAnnotation\Format\IntegerFormat;

final class TInteger extends TNumeral
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
