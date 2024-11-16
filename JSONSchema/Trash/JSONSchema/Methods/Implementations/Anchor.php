<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Anchor
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Anchor|null $anchor = null;

    public function anchor(string $value): Builder
    {
        $clone = clone $this;

        $clone->anchor = Draft202012::anchor($value);

        return $clone;
    }
}
