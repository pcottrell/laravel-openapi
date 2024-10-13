<?php

use MohammadAlavi\LaravelOpenApi\Builders\SecurityRequirementBuilder;
use MohammadAlavi\ObjectOrientedOpenAPI\Enums\OASVersion;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OpenApi;
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
            'openapi' => OASVersion::V_3_1_0->value,
            'security' => [
                [
                    'ASecuritySchemeFactory' => [],
                ],
                [
                    'BSecuritySchemeFactory' => [],
                    'ASecuritySchemeFactory' => [],
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
            ['openapi' => OASVersion::V_3_1_0->value],
        ],
//        'no security' => [
//            [(new SecurityRequirementBuilder())->build(NoSecurityScheme::class)],
//            ['openapi' => OASVersion::V_3_1_0->value],
//        ],
        'one element array security' => [
            [(new SecurityRequirementBuilder())->build(ASecuritySchemeFactory::class)],
            [
                'openapi' => OASVersion::V_3_1_0->value,
                'security' => [
                    [
                        'ASecuritySchemeFactory' => [],
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
                'openapi' => OASVersion::V_3_1_0->value,
                'security' => [
                    [
                        'ASecuritySchemeFactory' => [],
                    ],
                    [
                        'BSecuritySchemeFactory' => [],
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
                'openapi' => OASVersion::V_3_1_0->value,
                'security' => [
                    [
                        'BSecuritySchemeFactory' => [],
                    ],
                ],
            ],
        ],
    ]);
})->covers(OpenApi::class);
