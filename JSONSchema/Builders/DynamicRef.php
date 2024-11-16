<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface DynamicRef
{
    public function dynamicRef(string $uri): static;
}
