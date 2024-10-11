<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\ComponentFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityRequirement;

interface SecurityRequirementFactory extends ComponentFactory
{
    public function build(): SecurityRequirement;
}
