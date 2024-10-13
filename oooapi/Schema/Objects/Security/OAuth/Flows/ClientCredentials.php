<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flow;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\ScopeCollection;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final readonly class ClientCredentials extends Flow
{
    private function __construct(
        private string $tokenUrl,
        string|null $refreshUrl,
        ScopeCollection|null $scopeCollection,
    ) {
        parent::__construct($refreshUrl, $scopeCollection);
    }

    public static function create(
        string $tokenUrl,
        string|null $refreshUrl = null,
        ScopeCollection|null $scopeCollection = null,
    ): self {
        return new self($tokenUrl, $refreshUrl, $scopeCollection);
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'tokenUrl' => $this->tokenUrl,
            'refreshUrl' => $this->refreshUrl,
            'scopes' => $this->scopeCollection,
        ]);
    }
}
