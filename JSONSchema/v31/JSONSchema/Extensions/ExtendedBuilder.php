<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions;

use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\ExtendedBuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\Formats\IntegerFormat;
use MohammadAlavi\ObjectOrientedJSONSchema\BuilderDecorator;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\Formats\NumberFormat;

class ExtendedBuilder extends BuilderDecorator implements
    ExtendedBuilderInterface
{
    public function int32(): static
    {
        return $this->format(IntegerFormat::INT32);
    }

    public function int64(): static
    {
        return $this->format(IntegerFormat::INT64);
    }

    public function float(): static
    {
        return $this->format(NumberFormat::FLOAT);
    }

    public function double(): static
    {
        return $this->format(NumberFormat::DOUBLE);
    }
}
