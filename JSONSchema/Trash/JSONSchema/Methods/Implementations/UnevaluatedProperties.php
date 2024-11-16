<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\UnevaluatedProperties as UnevaluatedPropertiesKeyword;

trait UnevaluatedProperties
{
    private UnevaluatedPropertiesKeyword|null $unevaluatedProperties = null;

    public function unevaluatedProperties(Descriptor $descriptor): Builder
    {
        $clone = clone $this;

        $clone->unevaluatedProperties = Draft202012::unevaluatedProperties($descriptor);

        return $clone;
    }
}
