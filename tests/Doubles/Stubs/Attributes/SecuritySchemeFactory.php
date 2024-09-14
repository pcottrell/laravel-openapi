<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory as AbstractFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;

class SecuritySchemeFactory extends AbstractFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create();
    }
}
