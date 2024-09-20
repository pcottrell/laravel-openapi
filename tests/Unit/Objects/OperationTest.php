<?php

use MohammadAlavi\LaravelOpenApi\Collectors\SecurityRequirementBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\DefaultSecurityScheme;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\NoSecurityScheme;
use Tests\Doubles\Stubs\Objects\ASecuritySchemeFactory;
use Tests\Doubles\Stubs\Objects\BSecuritySchemeFactory;

describe('Operation', function (): void {
    it('can set security', function (array $securityReqs, array $expectation): void {
        $operation = new Operation();

        $result = $operation->security(...$securityReqs);

        expect($result->toArray())->toBe($expectation);
    })->with([
        'empty array [] security' => [
            [],
            [],
        ],
        'no security' => [
            [(new SecurityRequirementBuilder())->build(NoSecurityScheme::class)],
            [
                'security' => [],
            ],
        ],
        'default security' => [
            [(new SecurityRequirementBuilder())->build(DefaultSecurityScheme::class)],
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
})->covers(Operation::class);
