<?php

namespace Tests\Doubles\Stubs\SecuritySchemesFactories;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;

class JwtSecuritySchemeFactory extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create()
            ->name('JwtTestScheme')
            ->type(SecurityScheme::TYPE_HTTP)
            ->in(SecurityScheme::IN_HEADER)
            ->scheme('bearer')
            ->bearerFormat('JWT');
    }
}
