<?php

namespace MohammadAlavi\LaravelOpenApi\SecuritySchemes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;

class NoSecurityScheme extends SecuritySchemeFactory
{
    public const NAME = 'NoSecuritySecurityScheme';

    public function build(): SecurityScheme
    {
        return SecurityScheme::create('NoSecuritySecurityScheme')
            ->name('NoSecuritySecurityScheme');
    }
}