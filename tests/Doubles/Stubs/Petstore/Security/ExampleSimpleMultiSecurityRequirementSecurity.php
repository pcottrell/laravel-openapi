<?php

namespace Tests\Doubles\Stubs\Petstore\Security;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections\SecurityFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Security;
use Tests\Doubles\Stubs\Petstore\Security\SecurityRequirements\ExampleSingleApiKeySecurityRequirement;
use Tests\Doubles\Stubs\Petstore\Security\SecurityRequirements\ExampleSingleBearerSecurityRequirement;

class ExampleSimpleMultiSecurityRequirementSecurity implements SecurityFactory
{
    public function build(): Security
    {
        return Security::create(
            ExampleSingleBearerSecurityRequirement::create(),
            ExampleSingleApiKeySecurityRequirement::create(),
        );
    }
}
