<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use MohammadAlavi\LaravelOpenApi\Objects\SecurityRequirement;

class SecurityRequirementBuilder
{
    public function __construct(
        private readonly \MohammadAlavi\LaravelOpenApi\Builders\SecurityRequirementBuilder $securityRequirementBuilder,
    ) {
    }

    public function build(string|array|null $securitySchemeFactories): SecurityRequirement
    {
        return $this->securityRequirementBuilder->build($securitySchemeFactories);
    }
}
