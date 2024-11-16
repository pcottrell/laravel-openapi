<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait DynamicAnchor
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\DynamicAnchor|null $dynamicAnchor = null;

    public function dynamicAnchor(string $value): Builder
    {
        $clone = clone $this;

        $clone->dynamicAnchor = Draft202012::dynamicAnchor($value);

        return $clone;
    }
}
