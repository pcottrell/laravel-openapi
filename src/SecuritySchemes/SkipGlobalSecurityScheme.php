<?php

namespace Vyuldashev\LaravelOpenApi\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

class SkipGlobalSecurityScheme extends SecuritySchemeFactory
{
    // TODO: implement null/default object
    public function build(): SecurityScheme
    {
        return SecurityScheme::create(null)
            ->name('SkipGlobalSecurityScheme')
            ->scheme('SkipGlobalSecurityScheme');
    }
}
