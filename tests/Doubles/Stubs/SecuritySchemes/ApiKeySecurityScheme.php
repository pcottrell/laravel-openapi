<?php

namespace Tests\Doubles\Stubs\SecuritySchemes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;

class ApiKeySecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('ApiKey')
            ->name('X-API-KEY')
            ->type(SecurityScheme::TYPE_API_KEY)
            ->in(SecurityScheme::IN_HEADER)
            ->scheme('apiKey');
    }
}
