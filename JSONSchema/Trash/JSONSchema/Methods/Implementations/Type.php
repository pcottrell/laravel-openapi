<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Type
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Type|null $type = null;

    public function type(string ...$type): BuilderInterface
    {
        $clone = clone $this;

        $clone->type = Draft202012::type(...$type);

        return $clone;
    }
}
