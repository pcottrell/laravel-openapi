<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth\Flows;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth\Flow;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth\Scope;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

final readonly class AuthorizationCode extends Flow
{
    private function __construct(
        public string $authorizationUrl,
        public string $tokenUrl,
        string|null $refreshUrl = null,
        Scope ...$scope,
    ) {
        parent::__construct($refreshUrl, $scope);
    }

    public static function create(
        string $authorizationUrl,
        string $tokenUrl,
        string|null $refreshUrl = null,
        Scope ...$scope,
    ): self {
        return new self($authorizationUrl, $tokenUrl, $refreshUrl, ...$scope);
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'authorizationUrl' => $this->authorizationUrl,
            'tokenUrl' => $this->tokenUrl,
            'refreshUrl' => $this->refreshUrl,
            'scopes' => $this->scopes,
        ]);
    }
}
