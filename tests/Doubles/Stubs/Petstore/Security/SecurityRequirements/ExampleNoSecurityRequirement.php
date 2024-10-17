<?php

namespace Tests\Doubles\Stubs\Petstore\Security\SecurityRequirements;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\SecurityRequirementFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityRequirement;

final readonly class ExampleNoSecurityRequirement extends SecurityRequirementFactory
{
    public function build(): SecurityRequirement
    {
        return SecurityRequirement::create();
    }
}
