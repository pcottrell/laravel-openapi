<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;

interface UnevaluatedProperties
{
    public function unevaluatedProperties(BuilderInterface $schema): static;
}
