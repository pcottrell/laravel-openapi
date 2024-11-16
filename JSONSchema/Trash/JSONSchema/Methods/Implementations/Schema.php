<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Schema
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Schema|null $schema = null;

    public function schema(string $uri): Builder
    {
        $clone = clone $this;

        $clone->schema = Draft202012::schema($uri);

        return $clone;
    }
}
