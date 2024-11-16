<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

interface Required
{
    public function required(string ...$property): static;
}
