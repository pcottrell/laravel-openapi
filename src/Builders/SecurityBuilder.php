<?php

namespace Vyuldashev\LaravelOpenApi\Builders;

use Vyuldashev\LaravelOpenApi\Helpers\SecurityRequirementBuilderHelper;
use Vyuldashev\LaravelOpenApi\Objects\SecurityRequirement;

class SecurityBuilder
{
    public function __construct(
        private readonly SecurityRequirementBuilderHelper $securityRequirementBuilder,
    ) {
    }

    public function build(array $security): SecurityRequirement
    {
        return $this->securityRequirementBuilder->build($security);
    }
}
