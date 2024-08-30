<?php

namespace Tests\Unit\Attributes\Stubs;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;

class SecuritySchemeFactoryStub extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create();
    }
}