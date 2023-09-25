<?php

namespace Vyuldashev\LaravelOpenApi\Objects;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement;
use GoldSpecDigital\ObjectOrientedOAS\OpenApi as ParentOpenApi;

class OpenApi extends ParentOpenApi
{
    public function security(SecurityRequirement ...$security): self
    {
        $instance = clone $this;

        $instance->security = count($security) === 1 ? $security[0] : $security;
        $instance->noSecurity = null;

        return $instance;
    }
}
