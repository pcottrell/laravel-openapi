<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Schema
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Schema|null $schema = null;

    public function schema(string $uri): BuilderInterface
    {
        $clone = clone $this;

        $clone->schema = Draft202012::schema($uri);

        return $clone;
    }
}
