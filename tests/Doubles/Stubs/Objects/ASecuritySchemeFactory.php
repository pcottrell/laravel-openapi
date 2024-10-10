<?php

namespace Tests\Doubles\Stubs\Objects;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;

class ASecuritySchemeFactory extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create();
    }
}
