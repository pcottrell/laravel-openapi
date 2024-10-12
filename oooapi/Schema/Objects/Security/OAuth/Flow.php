<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\ReadonlyJsonSerializable;

abstract readonly class Flow extends ReadonlyJsonSerializable
{
    public Scopes|null $scopes;

    protected function __construct(
        public string|null $refreshUrl,
        Scopes|null $scopes,
    ) {
        $this->scopes = $scopes ?? Scopes::create();
    }
}
