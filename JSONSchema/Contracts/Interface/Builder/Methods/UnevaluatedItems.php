<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;

interface UnevaluatedItems
{
    public function unevaluatedItems(Builder $builder): static;
}
