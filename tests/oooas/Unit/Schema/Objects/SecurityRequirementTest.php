<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityRequirement;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;

describe('SecurityRequirement', function (): void {
    it('can be created with no parameters', function (): void {
        $securityRequirement = SecurityRequirement::create();

        expect($securityRequirement->jsonSerialize())->toBe([]);
    });

    it('can be created with all parameters', function (SecurityScheme|string $securityScheme, $expectation): void {
        $securityRequirement = SecurityRequirement::create()
            ->securityScheme($securityScheme)
            ->scopes('read:user');

        expect($securityRequirement->jsonSerialize())->toBe($expectation);
    })->with([
        'security object' => [
            SecurityScheme::create('SecObj'),
            [
                'SecObj' => ['scopes' => ['read:user']],
            ],
        ],
        'string security' => [
            'SecStr',
            [
                'SecStr' => ['scopes' => ['read:user']],
            ],
        ],
    ]);

    it('can be created with no scopes', function (SecurityScheme|string|null $securityScheme, array $expectation): void {
        $securityRequirement = SecurityRequirement::create()
            ->securityScheme($securityScheme);

        expect($securityRequirement->jsonSerialize())->toBe($expectation);
    })->with([
        'security scheme object' => [SecurityScheme::create('OAuth2'), [['OAuth2' => []]]],
        'security scheme name' => ['OAuth2', [['OAuth2' => []]]],
        // TODO: Are these two even valid OpenAPI 3.1 objects? I mean, with empty '' security name!
        'null security scheme name' => [null, []],
        'empty security scheme name' => ['', [['' => []]]],
    ]);

    it('can be created with scopes', function (...$scopes): void {
        $securityRequirement = SecurityRequirement::create()
            ->securityScheme('OAuth2')
            ->scopes(...$scopes);

        expect($securityRequirement->jsonSerialize())->toBe(['OAuth2' => compact('scopes')]);
    })->with([
        'with single scope' => ['read:user'],
        'with multiple scopes' => ['read:user', 'write:user'],
    ]);
})->covers(SecurityRequirement::class);
