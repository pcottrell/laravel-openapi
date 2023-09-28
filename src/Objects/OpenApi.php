<?php

namespace Vyuldashev\LaravelOpenApi\Objects;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement;
use GoldSpecDigital\ObjectOrientedOAS\OpenApi as ParentOpenApi;
use Vyuldashev\LaravelOpenApi\SecuritySchemes\PublicSecurityScheme;

class OpenApi extends ParentOpenApi
{
    /**
     * You should only send one security requirement per operation.
     * If you send more than one, the first one will be used.
     */
    public function security(SecurityRequirement ...$security): self
    {
        $instance = clone $this;

        if (empty($security)) {
            $instance->security = null;

            return $instance;
        }

        if ($this->hasNoGlobalSecurity($security[0])) {
            $instance->security = null;

            return $instance;
        }

        $instance->security = $security[0];

        return $instance;
    }

    private function hasNoGlobalSecurity(SecurityRequirement $security): bool
    {
        return $security->securityScheme === PublicSecurityScheme::NAME;
    }
}
