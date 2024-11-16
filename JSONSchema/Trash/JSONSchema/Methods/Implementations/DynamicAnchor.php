<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait DynamicAnchor
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\DynamicAnchor|null $dynamicAnchor = null;

    public function dynamicAnchor(string $value): BuilderInterface
    {
        $clone = clone $this;

        $clone->dynamicAnchor = Draft202012::dynamicAnchor($value);

        return $clone;
    }
}
