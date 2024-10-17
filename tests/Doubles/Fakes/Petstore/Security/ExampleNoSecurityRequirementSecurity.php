<?php

namespace Tests\Doubles\Fakes\Petstore\Security;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections\SecurityFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Security;
use Tests\Doubles\Fakes\Petstore\Security\SecurityRequirements\ExampleNoSecurityRequirement;

class ExampleNoSecurityRequirementSecurity implements SecurityFactory
{
    public function build(): Security
    {
        return Security::create(
            ExampleNoSecurityRequirement::create(),
        );
    }
}
