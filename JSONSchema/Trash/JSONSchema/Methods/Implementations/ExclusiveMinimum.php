<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait ExclusiveMinimum
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\ExclusiveMinimum|null $exclusiveMinimum = null;

    public function exclusiveMinimum(float $value): BuilderInterface
    {
        $clone = clone $this;

        $clone->exclusiveMinimum = Draft202012::exclusiveMinimum($value);

        return $clone;
    }
}
