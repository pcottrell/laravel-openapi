<?php

use MohammadAlavi\LaravelOpenApi\Collectors\SecurityRequirementBuilder;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\DefaultSecurityScheme;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\NoSecurityScheme;
use Tests\Doubles\Stubs\Objects\ASecuritySchemeFactory;
use Tests\Doubles\Stubs\Objects\BSecuritySchemeFactory;

describe('SecurityRequirementBuilder', function (): void {
    it('can be created with multi security', function (string|array|null $factories, array $expectation): void {
        $builder = new SecurityRequirementBuilder();

        $result = $builder->build($factories);

        expect($result->toArray())->toBe($expectation);
    })->with([
        'null' => [
            null,
            [
                [DefaultSecurityScheme::NAME => []],
            ],
        ],
        'empty string' => [
            '',
            [
                [DefaultSecurityScheme::NAME => []],
            ],
        ],
        'empty array [] security' => [
            [],
            [
                [NoSecurityScheme::NAME => []],
            ],
        ],
        'class string security' => [
            ASecuritySchemeFactory::class,
            [
                ['ASecurityScheme' => []],
            ],
        ],
        'nested single class string security' => [
            [[ASecuritySchemeFactory::class]],
            [
                ['ASecurityScheme' => []],
            ],
        ],
        'nested one multi class string security' => [
            [[ASecuritySchemeFactory::class, BSecuritySchemeFactory::class]],
            [
                ['ASecurityScheme' => [], 'BSecurityScheme' => []],
            ],
        ],
        'nested multiple multi class string security' => [
            [[ASecuritySchemeFactory::class, BSecuritySchemeFactory::class],
                [BSecuritySchemeFactory::class, ASecuritySchemeFactory::class], ],
            [
                ['ASecurityScheme' => [], 'BSecurityScheme' => []],
                ['BSecurityScheme' => [], 'ASecurityScheme' => []],
            ],
        ],
        'nested mixed multi class string security' => [
            [BSecuritySchemeFactory::class, [BSecuritySchemeFactory::class, ASecuritySchemeFactory::class]],
            [
                ['BSecurityScheme' => []],
                ['BSecurityScheme' => [], 'ASecurityScheme' => []],
            ],
        ],
        //        'nested single class string security with empty array' => [
        //            [[ASecuritySchemeFactory::class, []]],
        //            [
        //                ['ASecurityScheme' => []],
        //            ],
        //        ],
        'one element array security' => [
            [ASecuritySchemeFactory::class],
            [
                ['ASecurityScheme' => []],
            ],
        ],
        'multi element array security' => [
            [ASecuritySchemeFactory::class, BSecuritySchemeFactory::class],
            [
                [
                    'ASecurityScheme' => [],
                ],
                [
                    'BSecurityScheme' => [],
                ],
            ],
        ],
    ]);

    it('throws exception when invalid security configuration', function (string|array|null $factories): void {
        expect(function () use ($factories): void {
            $builder = new SecurityRequirementBuilder();

            $builder->build($factories);
        })->toThrow(RuntimeException::class, 'Invalid security configuration');
    })->with([
        'null array' => [
            [null],
            [],
        ],
        'empty string array' => [
            [''],
            [],
        ],
        'nested null array' => [
            [[null]],
            [],
        ],
        'nested empty string array' => [
            [['']],
            [],
        ],
        'nested empty array' => [
            [[]],
            [],
        ],
        'nested empty array with empty array' => [
            [[[]]],
            [],
        ],
    ]);

    it('can be created using security method', function (): void {
    })->todo();
})->covers(SecurityRequirementBuilder::class);
