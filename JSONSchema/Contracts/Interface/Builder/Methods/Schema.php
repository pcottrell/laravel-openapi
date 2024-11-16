<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

interface Schema
{
    public function schema(string $uri): static;
}
