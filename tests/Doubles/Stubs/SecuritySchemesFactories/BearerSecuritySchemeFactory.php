<?php

namespace Tests\Doubles\Stubs\SecuritySchemesFactories;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;

class BearerSecuritySchemeFactory extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create()
            ->type(SecurityScheme::TYPE_HTTP)
            ->scheme('bearer');
    }
}
