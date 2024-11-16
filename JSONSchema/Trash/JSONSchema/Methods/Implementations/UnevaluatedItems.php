<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\UnevaluatedItems as UnevaluatedItemsKeyword;

trait UnevaluatedItems
{
    private UnevaluatedItemsKeyword|null $unevaluatedItems = null;

    public function unevaluatedItems(Descriptor $schema): BuilderInterface
    {
        $clone = clone $this;

        $clone->unevaluatedItems = Draft202012::unevaluatedItems($schema);

        return $clone;
    }
}
