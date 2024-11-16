<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;

interface Items
{
    public function items(BuilderInterface $schema): static;
}
