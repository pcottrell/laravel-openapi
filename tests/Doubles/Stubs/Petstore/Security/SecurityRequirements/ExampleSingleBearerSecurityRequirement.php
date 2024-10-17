<?php

namespace Tests\Doubles\Stubs\Petstore\Security\SecurityRequirements;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\SecurityRequirementFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Requirement;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityRequirement;
use Tests\Doubles\Stubs\Petstore\Security\SecuritySchemes\ExampleHTTPBearerSecurityScheme;

final readonly class ExampleSingleBearerSecurityRequirement extends SecurityRequirementFactory
{
    public function build(): SecurityRequirement
    {
        return SecurityRequirement::create(
            Requirement::create(
                ExampleHTTPBearerSecurityScheme::create(),
            ),
        );
    }
}
