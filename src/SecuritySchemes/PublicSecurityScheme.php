<?php

namespace MohammadAlavi\LaravelOpenApi\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;

class PublicSecurityScheme extends SecuritySchemeFactory
{
    public const NAME = 'NoSecuritySecurityScheme';

    public function build(): SecurityScheme
    {
        return SecurityScheme::create('NoSecuritySecurityScheme')
            ->name('NoSecuritySecurityScheme');
    }
}
