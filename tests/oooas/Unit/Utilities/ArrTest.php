<?php

namespace Tests\oooas\Unit\Utilities;

use MohammadAlavi\LaravelOpenApi\oooas\Enums\OASVersion;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\OpenApi;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

describe('Arr', function (): void {
    it('removes null values', function (): void {
        $array = ['test' => null];

        $array = Arr::filter($array);

        expect($array)->toBeEmpty();
    });

    it('keeps non-null values', function (): void {
        $array = [
            'false' => false,
            '0' => 0,
            'string' => 'string',
            'object' => OpenApi::create(),
        ];

        $array = Arr::filter($array);

        expect($array)->toBe([
            'false' => false,
            '0' => 0,
            'string' => 'string',
            'object' => [
                'openapi' => OASVersion::V_3_1_0->value,
            ],
        ]);
    });

    it('skips specification extensions', function (): void {
        $array = [
            'x-test' => null,
        ];

        $array = Arr::filter($array);

        expect($array)->toBe([
            'x-test' => null,
        ]);
    });
})->covers(Arr::class);
