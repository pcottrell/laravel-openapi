<?php

namespace Tests\Doubles\Stubs\SecuritySchemesFactories;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;

class ApiKeySecuritySchemeFactory extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create()
            ->name('X-API-KEY')
            ->type(SecurityScheme::TYPE_API_KEY)
            ->in(SecurityScheme::IN_HEADER)
            ->scheme('apiKey');
    }
}
