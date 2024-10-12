<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flow;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Scopes;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final readonly class AuthorizationCode extends Flow
{
    private function __construct(
        public string $authorizationUrl,
        public string $tokenUrl,
        string|null $refreshUrl,
        Scopes|null $scopes,
    ) {
        parent::__construct($refreshUrl, $scopes);
    }

    public static function create(
        string $authorizationUrl,
        string $tokenUrl,
        string|null $refreshUrl = null,
        Scopes|null $scopes = null,
    ): self {
        return new self($authorizationUrl, $tokenUrl, $refreshUrl, $scopes);
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
