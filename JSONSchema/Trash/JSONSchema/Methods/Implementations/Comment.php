<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Comment
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Comment|null $comment = null;

    public function comment(string $value): Builder
    {
        $clone = clone $this;

        $clone->comment = Draft202012::comment($value);

        return $clone;
    }
}
