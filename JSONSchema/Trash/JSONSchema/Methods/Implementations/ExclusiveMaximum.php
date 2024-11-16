<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait ExclusiveMaximum
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\ExclusiveMaximum|null $exclusiveMaximum = null;

    public function exclusiveMaximum(float $value): Builder
    {
        $clone = clone $this;

        $clone->exclusiveMaximum = Draft202012::exclusiveMaximum($value);

        return $clone;
    }
}
