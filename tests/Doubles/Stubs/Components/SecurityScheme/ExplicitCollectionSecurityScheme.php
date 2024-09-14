<?php

namespace Tests\Doubles\Stubs\Components\SecurityScheme;

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;

#[Collection('test')]
class ExplicitCollectionSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create();
    }
}
