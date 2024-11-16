<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface Schema
{
    public function schema(string $uri): static;
}
