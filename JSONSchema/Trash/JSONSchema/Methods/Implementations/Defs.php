<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Defs\Def;

trait Defs
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Defs\Defs|null $defs = null;

    public function defs(Def ...$def): BuilderInterface
    {
        $clone = clone $this;

        $clone->defs = Draft202012::defs(...$def);

        return $clone;
    }
}
