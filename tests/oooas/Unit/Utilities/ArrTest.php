<?php

namespace Tests\oooas\Unit\Utilities;

use MohammadAlavi\ObjectOrientedOAS\OpenApi;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

describe('ArrTest', function (): void {
    it('removes null values', function (): void {
        $array = ['test' => null];

        $array = Arr::filter($array);

        expect($array)->toBeEmpty();
    });

    it('keeps non-null values', function (): void {
        $openApi = OpenApi::create();
        $array = [
            'false' => false,
            '0' => 0,
            'string' => 'string',
            'object' => $openApi,
        ];

        $array = Arr::filter($array);

        expect($array)->toBe([
            'false' => false,
            '0' => 0,
            'string' => 'string',
            'object' => $openApi,
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
