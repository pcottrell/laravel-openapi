<?php

namespace Tests\Doubles\Stubs\Components\SecurityScheme;

use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;

class ImplicitCollectionSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create();
    }
}
