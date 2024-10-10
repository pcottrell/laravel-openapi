<?php

namespace Tests\Doubles\Stubs\Collectors\Components\SecurityScheme;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;

class ImplicitCollectionSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create();
    }
}
