<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flow;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Scope;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final readonly class Implicit extends Flow
{
    private function __construct(
        public string $authorizationUrl,
        string|null $refreshUrl = null,
        Scope ...$scope,
    ) {
        parent::__construct($refreshUrl, $scope);
    }

    public static function create(
        string $authorizationUrl,
        string|null $refreshUrl = null,
        Scope ...$scope,
    ): self {
        return new self($authorizationUrl, $refreshUrl, ...$scope);
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'authorizationUrl' => $this->authorizationUrl,
            'refreshUrl' => $this->refreshUrl,
            'scopes' => $this->scopes,
        ]);
    }
}
