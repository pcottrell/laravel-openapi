<?php

namespace Vyuldashev\LaravelOpenApi\Objects;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Operation as ParentOperation;
use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement;
use Vyuldashev\LaravelOpenApi\SecuritySchemes\DefaultSecurityScheme;
use Vyuldashev\LaravelOpenApi\SecuritySchemes\PublicSecurityScheme;

class Operation extends ParentOperation
{
    /**
     * You should only send one security requirement per operation.
     * If you send more than one, the first one will be used.
     */
    public function security(SecurityRequirement ...$security): self
    {
        $instance = clone $this;

        // true overrides "global security" = [] in the generated OpenAPI spec
        // false/null uses $security
        // we disable it and use $security to configure the security.
        $instance = $instance->noSecurity(false);

        if ($this->shouldUseGlobalSecurity($security[0])) {
            $instance->security = null;

            return $instance;
        }

        if ($this->isPublic($security[0])) {
            $instance->security = [];

            return $instance;
        }

        $instance->security = $security[0];

        return $instance;
    }

    private function shouldUseGlobalSecurity(SecurityRequirement $security): bool
    {
        return $security->securityScheme === DefaultSecurityScheme::NAME;
    }

    private function isPublic(SecurityRequirement $security): bool
    {
        return $security->securityScheme === PublicSecurityScheme::NAME;
    }
}
