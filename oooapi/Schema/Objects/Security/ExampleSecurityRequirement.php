<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\SecurityRequirementFactory;

class ExampleSecurityRequirement implements SecurityRequirementFactory
{
    public function build(): SecurityRequirement
    {
        return SecurityRequirement::create(
            ExampleOAuth2SecurityScheme::create(),
            ExampleHTTPSecurityScheme::create(),
        );
    }
}
