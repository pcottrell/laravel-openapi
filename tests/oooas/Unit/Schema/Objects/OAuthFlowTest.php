<?php

use MohammadAlavi\ObjectOrientedOpenAPI\Exceptions\InvalidArgumentException;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OAuthFlow;

describe('OAuthFlow', function (): void {
    it('can be created with no parameters', function (): void {
        $oauthFlow = OAuthFlow::create();

        expect($oauthFlow->jsonSerialize())->toBeEmpty();
    });

    it('can be created with all parameters', function (array $scopes): void {
        $oauthFlow = OAuthFlow::create()
            ->flow(OAuthFlow::FLOW_AUTHORIZATION_CODE)
            ->authorizationUrl('https://api.example.com/oauth/authorization')
            ->tokenUrl('https://api.example.com/oauth/token')
            ->refreshUrl('https://api.example.com/oauth/token')
            ->scopes($scopes);

        expect($oauthFlow->jsonSerialize())->toBe([
            'authorizationUrl' => 'https://api.example.com/oauth/authorization',
            'tokenUrl' => 'https://api.example.com/oauth/token',
            'refreshUrl' => 'https://api.example.com/oauth/token',
            'scopes' => $scopes,
        ]);
    })->with([
        'with scopes' => [['read:user' => 'Read the user profile']],
        'explicit no scope' => [[]],
    ]);

    it('can be created with no scope', function (): void {
        $oauthFlow = OAuthFlow::create()->scopes(null);

        expect($oauthFlow->jsonSerialize())->toBeEmpty();
    });

    it('throws an exception when scopes is not an [string => string] array', function (array $scopes): void {
        expect(function () use ($scopes): void {
            OAuthFlow::create()->scopes($scopes);
        })->toThrow(InvalidArgumentException::class, 'Each scope must have a string key and a string value.');
    })->with([
        'no string key' => [[1 => 'read:user']],
        'no string value' => [['read:user' => 1]],
    ]);

    it('can be created with all combinations', function (string $flow, string $expectedFlow): void {
        $oauthFlow = OAuthFlow::create()->flow($flow);

        expect($oauthFlow->flow)->toBe($expectedFlow);
    })->with([
        'implicit' => ['implicit', OAuthFlow::FLOW_IMPLICIT],
        'password' => ['password', OAuthFlow::FLOW_PASSWORD],
        'clientCredentials' => ['clientCredentials', OAuthFlow::FLOW_CLIENT_CREDENTIALS],
        'authorizationCode' => ['authorizationCode', OAuthFlow::FLOW_AUTHORIZATION_CODE],
    ]);
})->covers(OAuthFlow::class);
