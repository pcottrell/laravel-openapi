<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface Ref
{
    public function ref(string $uri): static;
}
