<?php

namespace MohammadAlavi\LaravelOpenApi\SecuritySchemes;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;

class NoSecurityScheme extends SecuritySchemeFactory
{
    public const NAME = 'NoSecurityScheme';

    public function build(): SecurityScheme
    {
        return SecurityScheme::create()
            ->name('NoSecuritySecurityScheme');
    }
}
