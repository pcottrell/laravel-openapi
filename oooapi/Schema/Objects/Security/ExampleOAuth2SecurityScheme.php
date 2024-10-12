<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\AuthorizationCode;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Scope;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Scopes;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes\OAuth2;

class ExampleOAuth2SecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return OAuth2::create(
            Flows::create(
                authorizationCode: AuthorizationCode::create(
                    'https://example.com/oauth/authorize',
                    'https://example.com/oauth/token',
                    null,
                    Scopes::create(
                        Scope::create('read:users', 'Read users'),
                        Scope::create('read:products', 'Read product'),
                        Scope::create('write:products', 'Write product'),
                    ),
                ),
            ),
        );
    }
}
