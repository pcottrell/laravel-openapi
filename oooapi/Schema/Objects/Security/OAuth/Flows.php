<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\AuthorizationCode;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\ClientCredentials;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\Implicit;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\Password;

final readonly class Flows
{
    public function __construct(
        public Implicit|null $implicit = null,
        public Password|null $password = null,
        public ClientCredentials|null $clientCredentials = null,
        public AuthorizationCode|null $authorizationCode = null,
    ) {
    }
}
