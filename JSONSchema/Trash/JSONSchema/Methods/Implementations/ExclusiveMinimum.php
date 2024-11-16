<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait ExclusiveMinimum
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\ExclusiveMinimum|null $exclusiveMinimum = null;

    public function exclusiveMinimum(float $value): Builder
    {
        $clone = clone $this;

        $clone->exclusiveMinimum = Draft202012::exclusiveMinimum($value);

        return $clone;
    }
}
