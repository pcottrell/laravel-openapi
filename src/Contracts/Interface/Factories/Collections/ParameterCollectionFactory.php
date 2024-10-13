<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections;

use MohammadAlavi\LaravelOpenApi\Collections\ParameterCollection;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\ComponentFactory;

interface ParameterCollectionFactory extends ComponentFactory
{
    public function build(): ParameterCollection;
}
