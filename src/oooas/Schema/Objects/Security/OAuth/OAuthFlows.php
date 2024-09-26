<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth\Flows\AuthorizationCode;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth\Flows\ClientCredentials;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth\Flows\Implicit;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth\Flows\Password;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

final readonly class OAuthFlows
{
    public function __construct(
        public Implicit|null $implicit = null,
        public Password|null $password = null,
        public ClientCredentials|null $clientCredentials = null,
        public AuthorizationCode|null $authorizationCode = null,
    ) {
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
