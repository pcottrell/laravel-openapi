<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\ComponentFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Parameter;

interface ParameterFactory extends ComponentFactory
{
    /** @return Parameter[] */
    public function build(): array;
}
