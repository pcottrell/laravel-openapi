<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Type
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Type|null $type = null;

    public function type(string ...$type): Builder
    {
        $clone = clone $this;

        $clone->type = Draft202012::type(...$type);

        return $clone;
    }
}
