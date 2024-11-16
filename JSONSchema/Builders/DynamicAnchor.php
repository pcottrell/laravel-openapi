<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface DynamicAnchor
{
    public function dynamicAnchor(string $value): static;
}
