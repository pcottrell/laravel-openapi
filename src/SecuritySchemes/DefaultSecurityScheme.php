<?php

namespace Vyuldashev\LaravelOpenApi\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

class DefaultSecurityScheme extends SecuritySchemeFactory
{
    // TODO: implement null/default object
    public function build(): SecurityScheme
    {
        // 'null' objectId will cause the SecurityScheme to be skipped
        return SecurityScheme::create(null)
            ->name('DefaultSecurityScheme');
    }
}
