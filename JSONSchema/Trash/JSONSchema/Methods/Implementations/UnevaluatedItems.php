<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\UnevaluatedItems as UnevaluatedItemsKeyword;

trait UnevaluatedItems
{
    private UnevaluatedItemsKeyword|null $unevaluatedItems = null;

    public function unevaluatedItems(Descriptor $descriptor): Builder
    {
        $clone = clone $this;

        $clone->unevaluatedItems = Draft202012::unevaluatedItems($descriptor);

        return $clone;
    }
}
