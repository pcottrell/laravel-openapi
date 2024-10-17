<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\SchemaFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Abstract\Reusable\ReusableSchema;

abstract class ReusableSchemaFactory extends ReusableSchema implements SchemaFactory
{
    final protected static function componentPath(): string
    {
            return '/schemas';
    }
}