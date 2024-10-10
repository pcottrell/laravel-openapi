<?php

namespace Tests\Doubles\Fakes\Petstore\SecuritySchemes;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Exceptions\InvalidArgumentException;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OAuthFlow;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;

class OAuth2PasswordGrantSecurityScheme extends SecuritySchemeFactory
{
    /** @throws InvalidArgumentException */
    public function build(): SecurityScheme
    {
        return SecurityScheme::create()
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
