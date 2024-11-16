<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Id
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Id|null $id = null;

    public function id(string $uri): Builder
    {
        $clone = clone $this;

        $clone->id = Draft202012::id($uri);

        return $clone;
    }
}
