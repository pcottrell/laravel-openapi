<?php

use MohammadAlavi\LaravelOpenApi\Collectors\SecurityRequirementBuilder;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\OpenApi;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\NoSecurityScheme;
use Tests\Doubles\Stubs\Objects\ASecuritySchemeFactory;
use Tests\Doubles\Stubs\Objects\BSecuritySchemeFactory;

describe('OpenApi', function (): void {
    it('can be created with nested security', function (): void {
        $openApi = OpenApi::create();

        $result = $openApi->nestedSecurity([
            ASecuritySchemeFactory::class,
            [
                BSecuritySchemeFactory::class,
                ASecuritySchemeFactory::class,
            ],
        ]);

        expect($result->jsonSerialize())->toBe([
            'security' => [
                [
                    'ASecurityScheme' => [],
                ],
                [
                    'BSecurityScheme' => [],
                    'ASecurityScheme' => [],
                ],
            ],
        ]);
    });

    it('can be created using security method', function (array $securityReqs, array $expectation): void {
        $openApi = OpenApi::create();

        $result = $openApi->security(...$securityReqs);

        expect($result->jsonSerialize())->toBe($expectation);
    })->with([
        'empty array [] security' => [
            [],
            [],
        ],
        'no security' => [
            [(new SecurityRequirementBuilder())->build(NoSecurityScheme::class)],
            [],
        ],
        'one element array security' => [
            [(new SecurityRequirementBuilder())->build(ASecuritySchemeFactory::class)],
            [
                'security' => [
                    [
                        'ASecurityScheme' => [],
                    ],
                ],
            ],
        ],
        'nested security' => [
            [
                (new SecurityRequirementBuilder())->build([
                    ASecuritySchemeFactory::class,
                    BSecuritySchemeFactory::class,
                ]),
            ],
            [
                'security' => [
                    [
                        'ASecurityScheme' => [],
                    ],
                    [
                        'BSecurityScheme' => [],
                    ],
                ],
            ],
        ],
        'multiple nested security' => [
            [
                (new SecurityRequirementBuilder())->build([
                    BSecuritySchemeFactory::class,
                ]),
                (new SecurityRequirementBuilder())->build([
                    ASecuritySchemeFactory::class,
                    BSecuritySchemeFactory::class,
                ]),
            ],
            [
                'security' => [
                    [
                        'BSecurityScheme' => [],
                    ],
                ],
            ],
        ],
    ]);
})->covers(OpenApi::class);
