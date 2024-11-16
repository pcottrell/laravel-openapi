<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait MultipleOf
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\MultipleOf|null $multipleOf = null;

    public function multipleOf(float $value): BuilderInterface
    {
        $clone = clone $this;

        $clone->multipleOf = Draft202012::multipleOf($value);

        return $clone;
    }
}
