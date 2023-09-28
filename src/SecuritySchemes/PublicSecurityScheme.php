<?php

namespace Vyuldashev\LaravelOpenApi\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

class PublicSecurityScheme extends SecuritySchemeFactory
{
    public const NAME = 'NoSecuritySecurityScheme';

    public function build(): SecurityScheme
    {
        return SecurityScheme::create('NoSecuritySecurityScheme')
            ->name('NoSecuritySecurityScheme');
    }
}
