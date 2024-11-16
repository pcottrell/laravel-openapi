<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

interface Ref
{
    public function ref(string $uri): static;
}
