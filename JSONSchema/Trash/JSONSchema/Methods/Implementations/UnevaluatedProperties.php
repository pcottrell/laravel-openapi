<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\UnevaluatedProperties as UnevaluatedPropertiesKeyword;

trait UnevaluatedProperties
{
    private UnevaluatedPropertiesKeyword|null $unevaluatedProperties = null;

    public function unevaluatedProperties(Descriptor $schema): BuilderInterface
    {
        $clone = clone $this;

        $clone->unevaluatedProperties = Draft202012::unevaluatedProperties($schema);

        return $clone;
    }
}
