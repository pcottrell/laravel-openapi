<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Id
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Id|null $id = null;

    public function id(string $uri): BuilderInterface
    {
        $clone = clone $this;

        $clone->id = Draft202012::id($uri);

        return $clone;
    }
}
