<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Vocabulary\Vocab;

trait Vocabulary
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Vocabulary\Vocabulary|null $vocabulary = null;

    public function vocabulary(Vocab ...$vocab): BuilderInterface
    {
        $clone = clone $this;

        $clone->vocabulary = Draft202012::vocabulary(...$vocab);

        return $clone;
    }
}
