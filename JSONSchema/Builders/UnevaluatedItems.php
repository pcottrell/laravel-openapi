<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;

interface UnevaluatedItems
{
    public function unevaluatedItems(BuilderInterface $schema): static;
}
