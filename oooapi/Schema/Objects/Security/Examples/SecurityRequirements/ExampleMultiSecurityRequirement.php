<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\SecurityRequirements;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\Scopes\OrderShippingAddressScope;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\Scopes\OrderShippingStatusScope;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\SecuritySchemes\ExampleOAuth2AuthorizationCodeSecurityScheme;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\SecuritySchemes\ExampleOAuth2PasswordSecurityScheme;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Scopes;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\SecurityRequirementFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Requirement;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityRequirement;

final readonly class ExampleMultiSecurityRequirement extends SecurityRequirementFactory
{
    public function build(): SecurityRequirement
    {
        return SecurityRequirement::create(
            Requirement::create(
                ExampleOAuth2AuthorizationCodeSecurityScheme::create(),
                Scopes::create(
                    OrderShippingAddressScope::create(),
                    OrderShippingStatusScope::create(),
                ),
            ),
            Requirement::create(
                ExampleOAuth2PasswordSecurityScheme::create(),
                Scopes::create(
                    OrderShippingAddressScope::create(),
                    OrderShippingStatusScope::create(),
                ),
            ),
        );
    }
}
