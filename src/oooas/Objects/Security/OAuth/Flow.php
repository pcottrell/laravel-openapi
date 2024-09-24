<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Objects\Security\OAuth;

abstract readonly class Flow
{
    protected function __construct(
        public string|null $refreshUrl = null,
        public array $scopes = [],
    ) {
    }

    abstract public function toArray(): array;
}
