<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\AuthorizationCode;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\ClientCredentials;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\Implicit;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\Password;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\ReadonlyJsonSerializable;

final readonly class Flows extends ReadonlyJsonSerializable
{
    private function __construct(
        public Implicit|null $implicit = null,
        public Password|null $password = null,
        public ClientCredentials|null $clientCredentials = null,
        public AuthorizationCode|null $authorizationCode = null,
    ) {
    }

    public static function create(
        Implicit|null $implicit = null,
        Password|null $password = null,
        ClientCredentials|null $clientCredentials = null,
        AuthorizationCode|null $authorizationCode = null,
    ): self {
        return new self($implicit, $password, $clientCredentials, $authorizationCode);
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'implicit' => $this->implicit,
            'password' => $this->password,
            'clientCredentials' => $this->clientCredentials,
            'authorizationCode' => $this->authorizationCode,
        ]);
    }
}
