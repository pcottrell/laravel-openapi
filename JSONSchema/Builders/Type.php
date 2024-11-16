<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface Type
{
    public function type(string ...$type): static;
}
