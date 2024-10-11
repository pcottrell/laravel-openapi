<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections\SecurityFactory;

class ExampleSecurity implements SecurityFactory
{
    public function build(): Security
    {
        // TODO: Start from here tomorrow!
        // Here we have to pass the SecurityScheme and any applicable scopes for this specific endpoint to
        // Only Oauth2 and OpenIdConnect security schemes require scopes
        // Other security schemes do not require scopes but MAY have roles
        return Security::create(ExampleSecurityRequirement::class);
    }
}
