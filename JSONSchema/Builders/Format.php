<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\Formats\DefinedFormat;

interface Format
{
    public function format(DefinedFormat $value): static;
}
