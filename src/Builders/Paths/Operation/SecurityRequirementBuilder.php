<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityRequirement;

readonly class SecurityRequirementBuilder
{
    public function __construct(
        private \MohammadAlavi\LaravelOpenApi\Builders\SecurityRequirementBuilder $securityRequirementBuilder,
    ) {
    }

    public function build(string|array|null $securitySchemeFactories): SecurityRequirement
    {
        return $this->securityRequirementBuilder->build($securitySchemeFactories);
    }
}
