<?php

namespace Vyuldashev\LaravelOpenApi\Builders\Paths\Operation;

use Vyuldashev\LaravelOpenApi\Attributes\Operation as OperationAttribute;
use Vyuldashev\LaravelOpenApi\Helpers\SecurityRequirementBuilderHelper;
use Vyuldashev\LaravelOpenApi\Objects\RouteInformation;
use Vyuldashev\LaravelOpenApi\Objects\SecurityRequirement;

class SecurityBuilder
{
    public function __construct(
        private readonly SecurityRequirementBuilderHelper $securityRequirementBuilder,
    ) {
    }

    public function build(RouteInformation $route): SecurityRequirement
    {
        return $route->actionAttributes
            ->filter(static fn (object $attribute) => $attribute instanceof OperationAttribute)
            ->map(fn (OperationAttribute $attribute) => $this->securityRequirementBuilder->build($attribute->security))
            ->sole();
    }
}
