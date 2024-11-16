<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;

interface AdditionalProperties
{
    public function additionalProperties(BuilderInterface|bool $schema): static;
}
