<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

use MohammadAlavi\ObjectOrientedJSONSchema\Formats\DefinedFormat;

interface Format
{
    public function format(DefinedFormat $definedFormat): static;
}
