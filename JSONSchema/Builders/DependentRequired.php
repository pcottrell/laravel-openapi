<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\DependentRequired\Dependency;

interface DependentRequired
{
    public function dependentRequired(Dependency ...$dependency): static;
}
