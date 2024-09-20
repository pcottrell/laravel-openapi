<?php

namespace MohammadAlavi\LaravelOpenApi\Objects;

use MohammadAlavi\LaravelOpenApi\SecuritySchemes\DefaultSecurityScheme;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\NoSecurityScheme;
use MohammadAlavi\ObjectOrientedOAS\Objects\Operation as ParentOperation;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityRequirement;

class Operation extends ParentOperation
{
    /**
     * You should only send one security requirement per operation.
     * If you send more than one, the first one will be used.
     */
    public function security(SecurityRequirement ...$securityRequirement): static
    {
        if ([] === $securityRequirement) {
            return $this;
        }

        $instance = clone $this;

        // true overrides "global security" = [] in the generated OpenAPI spec
        // false/null uses $security
        // we disable it and use $security to configure the security.
        $instance = $instance->noSecurity(false);

        if ($this->shouldUseGlobalSecurity($securityRequirement[0])) {
            $instance->security = null;

            return $instance;
        }

        if ($this->isPublic($securityRequirement[0])) {
            $instance->security = [];

            return $instance;
        }

        $instance->security = $securityRequirement[0];

        return $instance;
    }

    private function shouldUseGlobalSecurity(SecurityRequirement $securityRequirement): bool
    {
        return DefaultSecurityScheme::NAME === $securityRequirement->securityScheme;
    }

    private function isPublic(SecurityRequirement $securityRequirement): bool
    {
        return NoSecurityScheme::NAME === $securityRequirement->securityScheme;
    }
}
