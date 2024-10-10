<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Services\ComponentCollector;
use Pest\Expectation;

describe('CollectionLocator', function (): void {
    it('can collect specific collections', function (): void {
        $locator = new ComponentCollector([
            __DIR__ . '/../../Doubles/Stubs/Collectors/Components',
        ]);

        $result = $locator->collect('test');

        expect($result)->toHaveCount(10)
            ->and($result)->each(
                fn (Expectation $expectation) => $expectation->toUse(Collection::class),
            );
    });
})->covers(ComponentCollector::class);
