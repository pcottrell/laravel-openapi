<?php

namespace Vyuldashev\LaravelOpenApi\Objects;

use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement as ParentSecurityRequirement;

class SecurityRequirement extends ParentSecurityRequirement
{
    protected function generate(): array
    {
        return [parent::generate()];
    }
}
