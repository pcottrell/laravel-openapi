<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Enums\SecuritySchemeType;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\ReadonlyGenerator;

abstract readonly class SecurityScheme extends ReadonlyGenerator
{
    protected function __construct(
        protected SecuritySchemeType $type,
        protected string|null $description,
    ) {
    }
}
