<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

interface DefaultValue
{
    public function default(mixed $value): static;
}
