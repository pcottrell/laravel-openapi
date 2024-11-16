<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Minimum
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Minimum|null $minimum = null;

    public function minimum(float $value): Builder
    {
        $clone = clone $this;

        $clone->minimum = Draft202012::minimum($value);

        return $clone;
    }
}
