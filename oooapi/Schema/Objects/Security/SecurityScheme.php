<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Enums\SecuritySchemeType;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\ReadonlyJsonSerializable;

abstract readonly class SecurityScheme extends ReadonlyJsonSerializable
{
    protected function __construct(
        public SecuritySchemeType $type,
        public string|null $description,
    ) {
    }
}
