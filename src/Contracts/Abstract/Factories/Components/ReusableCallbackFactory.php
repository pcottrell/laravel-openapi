<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\CallbackFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Abstract\Reusable\ReusableComponent;

abstract class ReusableCallbackFactory extends ReusableComponent implements CallbackFactory
{
    final protected static function componentPath(): string
    {
            return '/callbacks';
    }
}