<?php

namespace Tests\Doubles\Stubs\Attributes;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory as AbstractFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;

class SecuritySchemeFactory extends AbstractFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create();
    }
}
