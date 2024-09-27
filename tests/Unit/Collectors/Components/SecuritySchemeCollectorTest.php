<?php

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Collectors\CollectionLocator;
use MohammadAlavi\LaravelOpenApi\Collectors\Components\SecuritySchemeCollector;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;

describe('SecuritySchemeCollector', function (): void {
    beforeEach(function (): void {
        $locator = new CollectionLocator([__DIR__ . '/../../../Doubles/Stubs/Collectors/Components/SecurityScheme']);
        $this->collector = new SecuritySchemeCollector($locator);
    });

    it('can collect security scheme with default collection', function (): void {
        $result = $this->collector->collect();

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->count())->toBe(2)
            ->and($result->first())->toBeInstanceOf(SecurityScheme::class);
    });

    it('can collect security scheme with specified collection', function (): void {
        $result = $this->collector->collect('test');

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->count())->toBe(2)
            ->and($result->first())->toBeInstanceOf(SecurityScheme::class);
    });

    it('returns empty collection when no factories found', function (): void {
        $locator = new CollectionLocator([]);
        $collector = new SecuritySchemeCollector($locator);

        $result = $collector->collect();

        expect($result)->toBeInstanceOf(Collection::class)
            ->and($result->isEmpty())->toBeTrue();
    });
})->covers(SecuritySchemeCollector::class);
