<?php

namespace Vyuldashev\LaravelOpenApi\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

class DefaultSecurityScheme extends SecuritySchemeFactory
{
    public const NAME = 'DefaultSecurityScheme';

    public function build(): SecurityScheme
    {
        return SecurityScheme::create('DefaultSecurityScheme')
            ->name('DefaultSecurityScheme');
    }
}
