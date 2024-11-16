<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Maximum
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Maximum|null $maximum = null;

    public function maximum(float $value): BuilderInterface
    {
        $clone = clone $this;

        $clone->maximum = Draft202012::maximum($value);

        return $clone;
    }
}
