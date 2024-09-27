<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth\Flows\AuthorizationCode;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth\Flows\ClientCredentials;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth\Flows\Implicit;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\OAuth\Flows\Password;

final readonly class OAuthFlows
{
    public function __construct(
        public Implicit|null $implicit = null,
        public Password|null $password = null,
        public ClientCredentials|null $clientCredentials = null,
        public AuthorizationCode|null $authorizationCode = null,
    ) {
    }
}
