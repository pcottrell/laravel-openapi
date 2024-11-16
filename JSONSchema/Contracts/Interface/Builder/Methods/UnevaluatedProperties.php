<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;

interface UnevaluatedProperties
{
    public function unevaluatedProperties(Builder $builder): static;
}
