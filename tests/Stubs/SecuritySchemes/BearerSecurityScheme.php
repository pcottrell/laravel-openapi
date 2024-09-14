<?php

namespace Tests\Stubs\SecuritySchemes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;

class BearerSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('Bearer')
            ->type(SecurityScheme::TYPE_HTTP)
            ->scheme('bearer');
    }
}
