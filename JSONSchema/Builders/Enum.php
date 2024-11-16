<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface Enum
{
    public function enum(mixed ...$value): static;
}
