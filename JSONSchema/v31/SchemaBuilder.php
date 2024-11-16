<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31;

use MohammadAlavi\ObjectOrientedJSONSchema\v31\Contracts\Interface\Builder\BuilderExtension;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Formats\IntegerFormat;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Abstract\SchemaBuilderDecorator;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Formats\NumberFormat;

class SchemaBuilder extends SchemaBuilderDecorator implements
    BuilderExtension
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
