<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Objects\Security\OAuth\Flows;

use MohammadAlavi\LaravelOpenApi\oooas\Objects\Security\OAuth\Flow;
use MohammadAlavi\LaravelOpenApi\oooas\Objects\Security\OAuth\Scope;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

final readonly class AuthorizationCode extends Flow
{
    private function __construct(
        public string $authorizationUrl,
        public string $tokenUrl,
        string|null $refreshUrl = null,
        Scope ...$scopes,
    ) {
        parent::__construct($refreshUrl, $scopes);
    }

    public static function create(
        string $authorizationUrl,
        string $tokenUrl,
        string|null $refreshUrl = null,
        Scope ...$scopes,
    ): self {
        return new self($authorizationUrl, $tokenUrl, $refreshUrl, ...$scopes);
    }

    public function toArray(): array
    {
        return Arr::filter([
            'authorizationUrl' => $this->authorizationUrl,
            'tokenUrl' => $this->tokenUrl,
            'refreshUrl' => $this->refreshUrl,
            'scopes' => $this->scopes,
        ]);
    }
}
