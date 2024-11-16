<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait MinLength
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\MinLength|null $minLength = null;

    public function minLength(int $value): Builder
    {
        $clone = clone $this;

        $clone->minLength = Draft202012::minLength($value);

        return $clone;
    }
}
