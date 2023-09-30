<?php

namespace Vyuldashev\LaravelOpenApi\Builders\Paths\Operation;

use Vyuldashev\LaravelOpenApi\Objects\SecurityRequirement;

class SecurityRequirementBuilder
{
    public function __construct(
        private readonly \Vyuldashev\LaravelOpenApi\Builders\SecurityRequirementBuilder $securityRequirementBuilder,
    ) {
    }

    public function build(string|array|null $securitySchemeFactories): SecurityRequirement
    {
        return $this->securityRequirementBuilder->build($securitySchemeFactories);
    }
}
