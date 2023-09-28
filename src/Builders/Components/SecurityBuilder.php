<?php

namespace Vyuldashev\LaravelOpenApi\Builders\Components;

use Vyuldashev\LaravelOpenApi\Builders\SecurityRequirementBuilder;
use Vyuldashev\LaravelOpenApi\Objects\SecurityRequirement;

class SecurityBuilder
{
    public function __construct(
        private readonly SecurityRequirementBuilder $securityRequirementBuilder,
    ) {
    }

    public function build(array $security): SecurityRequirement
    {
        return $this->securityRequirementBuilder->build($security);
    }
}
