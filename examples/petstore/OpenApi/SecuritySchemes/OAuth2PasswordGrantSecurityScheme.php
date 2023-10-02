<?php

namespace Examples\Petstore\OpenApi\SecuritySchemes;

use GoldSpecDigital\ObjectOrientedOAS\Objects\OAuthFlow;
use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Factories\SecuritySchemeFactory;

class OAuth2PasswordGrantSecurityScheme extends SecuritySchemeFactory
{
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
                    ])
            );
    }
}