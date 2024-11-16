<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Methods;

use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\DependentRequired\Dependency;

interface DependentRequired
{
    public function dependentRequired(Dependency ...$dependency): static;
}
