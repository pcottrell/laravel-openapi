<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\ReadonlyJsonSerializable;

abstract readonly class Flow extends ReadonlyJsonSerializable
{
    protected function __construct(
        public string|null $refreshUrl = null,
        public array $scopes = [],
    ) {
    }
}
