<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface DefaultValue
{
    public function default(mixed $value): static;
}
