<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait MaxLength
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\MaxLength|null $maxLength = null;

    public function maxLength(int $value): Builder
    {
        $clone = clone $this;

        $clone->maxLength = Draft202012::maxLength($value);

        return $clone;
    }
}
