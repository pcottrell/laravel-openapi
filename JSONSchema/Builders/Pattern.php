<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface Pattern
{
    public function pattern(string $value): static;
}
