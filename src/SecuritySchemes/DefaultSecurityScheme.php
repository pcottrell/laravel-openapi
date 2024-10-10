<?php

namespace MohammadAlavi\LaravelOpenApi\SecuritySchemes;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;

class DefaultSecurityScheme extends SecuritySchemeFactory
{
    // TODO: use the reusable name() method
    public const NAME = 'DefaultSecurityScheme';

    public function build(): SecurityScheme
    {
        return SecurityScheme::create()
            ->name('DefaultSecurityScheme');
    }
}
