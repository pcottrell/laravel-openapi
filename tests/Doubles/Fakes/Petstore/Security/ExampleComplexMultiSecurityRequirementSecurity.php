<?php

namespace Tests\Doubles\Fakes\Petstore\Security;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections\SecurityFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Security;
use Tests\Doubles\Fakes\Petstore\Security\SecurityRequirements\ExampleMultiSecurityRequirement;
use Tests\Doubles\Fakes\Petstore\Security\SecurityRequirements\ExampleSingleBearerSecurityRequirement;

class ExampleComplexMultiSecurityRequirementSecurity implements SecurityFactory
{
    public function build(): Security
    {
        return Security::create(
            ExampleSingleBearerSecurityRequirement::create(),
            ExampleMultiSecurityRequirement::create(),
        );
    }
}
