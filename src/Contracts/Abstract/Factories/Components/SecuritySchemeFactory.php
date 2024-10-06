<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\SecuritySchemeFactory as SecuritySchemeFactoryContract;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ReusableComponent;

abstract class SecuritySchemeFactory extends ReusableComponent implements SecuritySchemeFactoryContract
{
    final protected static function componentPath(): string
    {
        return '/securitySchemes';
    }
}
