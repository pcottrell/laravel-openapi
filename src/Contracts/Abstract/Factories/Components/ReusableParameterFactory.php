<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\ParameterFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Abstract\Reusable\ReusableComponent;

abstract class ReusableParameterFactory extends ReusableComponent implements ParameterFactory
{
    final protected static function componentPath(): string
    {
        return '/parameters';
    }
}
