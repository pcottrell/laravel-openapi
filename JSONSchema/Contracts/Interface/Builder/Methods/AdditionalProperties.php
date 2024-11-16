<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;

interface AdditionalProperties
{
    public function additionalProperties(Builder|bool $schema): static;
}
