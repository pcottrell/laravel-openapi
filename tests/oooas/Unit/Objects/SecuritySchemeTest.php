<?php

use MohammadAlavi\ObjectOrientedOAS\Objects\OAuthFlow;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityScheme;

describe('SecurityScheme', function (): void {
    it('can be created with no parameters', function (): void {
        $securityScheme = SecurityScheme::create();

        expect($securityScheme->toArray())->toBeEmpty();
    });

    it('can be created with all parameters', function (): void {
        $oauthFlow = OAuthFlow::create()
            ->flow(OAuthFlow::FLOW_CLIENT_CREDENTIALS);

        $securityScheme = SecurityScheme::create()
            ->name('OAuth2')
            ->type(SecurityScheme::TYPE_OAUTH2)
            ->description('Standard auth')
            ->in(SecurityScheme::IN_HEADER)
            ->scheme('basic')
            ->bearerFormat('JWT')
            ->flows($oauthFlow)
            ->openIdConnectUrl('https://example.com');

        expect($securityScheme->toArray())->toBe([
            'type' => 'oauth2',
            'description' => 'Standard auth',
            'name' => 'OAuth2',
            'in' => 'header',
            'scheme' => 'basic',
            'bearerFormat' => 'JWT',
            'flows' => [
                'clientCredentials' => [],
            ],
            'openIdConnectUrl' => 'https://example.com',
        ]);
    });

    it('can create an OAuth2 security scheme', function (): void {
        $securityScheme = SecurityScheme::oauth2();

        expect($securityScheme->type)->toBe(SecurityScheme::TYPE_OAUTH2);
    });

    it('can be created with all combinations', function (string $type, string $expectedType): void {
        $securityScheme = SecurityScheme::create()->type($type);

        expect($securityScheme->type)->toBe($expectedType);
    })->with([
        'apiKey' => ['apiKey', SecurityScheme::TYPE_API_KEY],
        'http' => ['http', SecurityScheme::TYPE_HTTP],
        'oauth2' => ['oauth2', SecurityScheme::TYPE_OAUTH2],
        'openIdConnect' => ['openIdConnect', SecurityScheme::TYPE_OPEN_ID_CONNECT],
    ])->with([
        'query' => ['query', SecurityScheme::IN_QUERY],
        'header' => ['header', SecurityScheme::IN_HEADER],
        'cookie' => ['cookie', SecurityScheme::IN_COOKIE],
    ]);
})->covers(SecurityScheme::class);
