<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;
use MohammadAlavi\ObjectOrientedJSONSchema\Formats\StringFormat;

trait Format
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Format|null $format = null;

    public function format(StringFormat $stringFormat): Builder
    {
        $clone = clone $this;

        $clone->format = Draft202012::format($stringFormat);

        return $clone;
    }
}
