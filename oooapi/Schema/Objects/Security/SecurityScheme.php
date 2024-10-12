<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security;

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\ReadonlyJsonSerializable;

abstract readonly class SecurityScheme extends ReadonlyJsonSerializable
{
    protected function __construct(
        public string $type,
        public string|null $description,
    ) {
    }
}
