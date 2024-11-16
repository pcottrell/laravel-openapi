<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

interface Enum
{
    public function enum(mixed ...$value): static;
}
