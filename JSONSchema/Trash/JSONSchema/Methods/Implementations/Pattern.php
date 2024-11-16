<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Pattern
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Pattern|null $pattern = null;

    public function pattern(string $value): BuilderInterface
    {
        $clone = clone $this;

        $clone->pattern = Draft202012::pattern($value);

        return $clone;
    }
}
