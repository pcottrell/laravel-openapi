<?php

namespace MohammadAlavi\LaravelOpenApi\Factories\Component;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;

abstract class SecuritySchemeFactory
{
    abstract public function build(): SecurityScheme;
}
