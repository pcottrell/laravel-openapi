<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait DynamicRef
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\DynamicRef|null $dynamicRef = null;

    public function dynamicRef(string $uri): Builder
    {
        $clone = clone $this;

        $clone->dynamicRef = Draft202012::dynamicRef($uri);

        return $clone;
    }
}
