<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Maximum
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Maximum|null $maximum = null;

    public function maximum(float $value): Builder
    {
        $clone = clone $this;

        $clone->maximum = Draft202012::maximum($value);

        return $clone;
    }
}
