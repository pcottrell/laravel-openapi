<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

abstract readonly class Flow
{
    protected function __construct(
        public string|null $refreshUrl = null,
        public array $scopes = [],
    ) {
    }

    abstract protected function toArray(): array;
}
