<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations;

use MohammadAlavi\LaravelOpenApi\Objects\SecurityRequirement;

readonly class SecurityRequirementBuilder
{
    public function __construct(
        private \MohammadAlavi\LaravelOpenApi\Collectors\SecurityRequirementBuilder $securityRequirementBuilder,
    ) {
    }

    public function build(string|array|null $securitySchemeFactories): SecurityRequirement
    {
        return $this->securityRequirementBuilder->build($securitySchemeFactories);
    }
}
