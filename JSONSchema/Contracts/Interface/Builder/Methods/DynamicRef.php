<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

interface DynamicRef
{
    public function dynamicRef(string $uri): static;
}
