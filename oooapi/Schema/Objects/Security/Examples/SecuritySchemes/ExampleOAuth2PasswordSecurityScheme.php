<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\SecuritySchemes;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\Scopes\OrderItemScope;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\Scopes\OrderPaymentScope;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\Scopes\OrderScope;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\Scopes\OrderShippingAddressScope;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\Scopes\OrderShippingStatusScope;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Flows\Password;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Scopes;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes\OAuth2;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityScheme;

class ExampleOAuth2PasswordSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return OAuth2::create(
            Flows::create(
                password: Password::create(
                    'https://example.com/oauth/authorize',
                    'https://example.com/oauth/token',
                    Scopes::create(
                        OrderScope::create(),
                        OrderItemScope::create(),
                        OrderPaymentScope::create(),
                        OrderShippingAddressScope::create(),
                        OrderShippingStatusScope::create(),
                    ),
                ),
            ),
        );
    }
}
