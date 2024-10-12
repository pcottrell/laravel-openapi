<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections\SecurityFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\SecurityRequirements\ExampleMultiSecurityRequirement;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\SecurityRequirements\ExampleSecurityRequirement;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Security;

class ExampleSecurity implements SecurityFactory
{
    public function build(): Security
    {
        return Security::create(
            ExampleSecurityRequirement::create(),
            ExampleMultiSecurityRequirement::create(),
        );
    }
}
