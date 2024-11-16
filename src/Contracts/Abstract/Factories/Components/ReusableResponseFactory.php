<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\ResponseFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Abstract\Reusable\ReusableComponent;

abstract class ReusableResponseFactory extends ReusableComponent implements ResponseFactory
{
    final protected static function componentPath(): string
    {
        return '/responses';
    }
}
