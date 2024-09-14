<?php

namespace Tests\Doubles\Fakes\Petstore\SecuritySchemes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;

class BearerTokenSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('BearerToken')
            ->type(SecurityScheme::TYPE_HTTP)
            ->scheme('bearer');
    }
}
