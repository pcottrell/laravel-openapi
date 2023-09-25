<?php

namespace Vyuldashev\LaravelOpenApi\Objects;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Operation as ParentOperation;
use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement;

class Operation extends ParentOperation
{
    public function security(SecurityRequirement ...$security): self
    {
        $instance = clone $this;

        if (count($security) === 1) {
            if (is_null($security[0]->securityScheme)) {
                $instance->security = null;
            } else {
                $instance->security = $security[0];
            }
        } else {
            $instance->security = $security ?: null;
        }
        $instance->noSecurity = null;

        return $instance;
    }
}
