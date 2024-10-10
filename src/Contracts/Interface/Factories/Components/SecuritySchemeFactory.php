<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\ComponentFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;

interface SecuritySchemeFactory extends ComponentFactory
{
    public function build(): SecurityScheme;
}
