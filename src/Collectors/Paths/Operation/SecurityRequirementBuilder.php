<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operation;

use MohammadAlavi\LaravelOpenApi\Objects\SecurityRequirement;

class SecurityRequirementBuilder
{
    public function __construct(
        private readonly \MohammadAlavi\LaravelOpenApi\Collectors\SecurityRequirementBuilder $securityRequirementBuilder,
    ) {
    }

    public function build(string|array|null $securitySchemeFactories): SecurityRequirement
    {
        return $this->securityRequirementBuilder->build($securitySchemeFactories);
    }
}
