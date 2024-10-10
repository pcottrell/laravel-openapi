<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\RequestBodyFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Abstract\Reusable\ReusableComponent;

abstract class ReusableRequestBodyFactory extends ReusableComponent implements RequestBodyFactory
{
    final protected static function componentPath(): string
    {
            return '/requestBodies';
    }
}
