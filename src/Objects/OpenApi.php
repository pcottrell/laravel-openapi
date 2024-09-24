<?php

namespace MohammadAlavi\LaravelOpenApi\Objects;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\CircularDependencyException;
use MohammadAlavi\LaravelOpenApi\Collectors\SecurityRequirementBuilder;
use MohammadAlavi\LaravelOpenApi\oooas\Objects\SecurityRequirement;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\NoSecurityScheme;
use MohammadAlavi\ObjectOrientedOAS\OpenApi as ParentOpenApi;

class OpenApi extends ParentOpenApi
{
    // This is just a wrapper around parent class security()
    // to allow for multiple security requirements
    /**
     * @throws CircularDependencyException
     * @throws BindingResolutionException
     */
    public function nestedSecurity(array $security): static
    {
        $securityRequirements = app(SecurityRequirementBuilder::class)->build($security);

        return $this->security($securityRequirements);
    }

    /**
     * You should only send one security requirement per operation.
     * If you send more than one, the first one will be used.
     */
    public function security(SecurityRequirement ...$securityRequirement): static
    {
        $instance = clone $this;

        if ([] === $securityRequirement) {
            $instance->security = null;

            return $instance;
        }

        if ($this->hasNoGlobalSecurity($securityRequirement[0])) {
            $instance->security = null;

            return $instance;
        }

        $instance->security = $securityRequirement[0];

        return $instance;
    }

    private function hasNoGlobalSecurity(SecurityRequirement $securityRequirement): bool
    {
        return NoSecurityScheme::NAME === $securityRequirement->securityScheme;
    }
}
