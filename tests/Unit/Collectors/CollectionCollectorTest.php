<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Services\ComponentCollector;
use Pest\Expectation;

describe(class_basename(ComponentCollector::class), function (): void {
    it('can collect specific collections', function (): void {
        $sut = new ComponentCollector([
            __DIR__ . '/../../Doubles/Stubs/Collectors/Components',
        ]);

        $result = $sut->collect('test');

        expect($result)->toHaveCount(10)
            ->and($result)->each(
                fn (Expectation $expectation) => $expectation->toUse(Collection::class),
            );
    });
})->covers(ComponentCollector::class);
