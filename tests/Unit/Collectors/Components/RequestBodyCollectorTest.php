<?php

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Collectors\CollectionLocator;
use MohammadAlavi\LaravelOpenApi\Collectors\Components\RequestBodyCollector;
use MohammadAlavi\ObjectOrientedOAS\Objects\RequestBody;

describe('RequestBodyCollector', function (): void {
    beforeEach(function () {
        $locator = new CollectionLocator([__DIR__ . '/../../../Doubles/Stubs/Collectors/Components/RequestBody']);
        $this->collector = new RequestBodyCollector($locator);
    });

    it('can collect request body factories with default collection', function (): void {
        $result = $this->collector->collect();

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->count())->toBe(1)
            ->and($result->first())->toBeInstanceOf(RequestBody::class);
    });

    it('can collect request body factories with specified collection', function (): void {
        $result = $this->collector->collect('test');

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->count())->toBe(1)
            ->and($result->first())->toBeInstanceOf(RequestBody::class);
    });

    it('returns empty collection when no factories found', function (): void {
        $locator = new CollectionLocator([]);
        $collector = new RequestBodyCollector($locator);

        $result = $collector->collect();

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->isEmpty())->toBeTrue();
    });
})->covers(RequestBodyCollector::class);
