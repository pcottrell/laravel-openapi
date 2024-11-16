<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait DynamicRef
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\DynamicRef|null $dynamicRef = null;

    public function dynamicRef(string $uri): BuilderInterface
    {
        $clone = clone $this;

        $clone->dynamicRef = Draft202012::dynamicRef($uri);

        return $clone;
    }
}
