<?php

namespace Tests\Doubles\Fakes\Petstore\SecuritySchemes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\OAuthFlow;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;
use MohammadAlavi\ObjectOrientedOAS\Exceptions\InvalidArgumentException;

class OAuth2PasswordGrantSecurityScheme extends SecuritySchemeFactory
{
    /** @throws InvalidArgumentException */
    public function build(): SecurityScheme
    {
        return SecurityScheme::create('OAuth2PasswordGrant')
            ->type(SecurityScheme::TYPE_OAUTH2)
            ->flows(
                OAuthFlow::create()
                    ->flow('password')
                    ->authorizationUrl(env('APP_URL') . '/v1/oauth/authorize')
                    ->tokenUrl(env('APP_URL') . '/v1/oauth/token')
                    ->refreshUrl(env('APP_URL') . '/v1/oauth/refresh')
                    ->scopes([
                        'read' => 'Read access',
                        'write' => 'Write access',
                    ]),
            );
    }
}
