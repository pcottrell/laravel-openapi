<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

interface Required
{
    public function required(string ...$property): static;
}
