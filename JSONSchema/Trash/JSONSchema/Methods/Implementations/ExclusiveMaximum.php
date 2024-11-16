<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait ExclusiveMaximum
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\ExclusiveMaximum|null $exclusiveMaximum = null;

    public function exclusiveMaximum(float $value): BuilderInterface
    {
        $clone = clone $this;

        $clone->exclusiveMaximum = Draft202012::exclusiveMaximum($value);

        return $clone;
    }
}
