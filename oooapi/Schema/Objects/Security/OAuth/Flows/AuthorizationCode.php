<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flow;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\ScopeCollection;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final readonly class AuthorizationCode extends Flow
{
    private function __construct(
        private string $authorizationUrl,
        private string $tokenUrl,
        string|null $refreshUrl,
        ScopeCollection|null $scopeCollection,
    ) {
        parent::__construct($refreshUrl, $scopeCollection);
    }

    public static function create(
        string $authorizationUrl,
        string $tokenUrl,
        string|null $refreshUrl = null,
        ScopeCollection|null $scopeCollection = null,
    ): self {
        return new self($authorizationUrl, $tokenUrl, $refreshUrl, $scopeCollection);
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'authorizationUrl' => $this->authorizationUrl,
            'tokenUrl' => $this->tokenUrl,
            'refreshUrl' => $this->refreshUrl,
            'scopes' => $this->scopeCollection,
        ]);
    }
}