<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;
use MohammadAlavi\ObjectOrientedJSONSchema\Formats\StringFormat;

trait Format
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Format|null $format = null;

    public function format(StringFormat $value): BuilderInterface
    {
        $clone = clone $this;

        $clone->format = Draft202012::format($value);

        return $clone;
    }
}
