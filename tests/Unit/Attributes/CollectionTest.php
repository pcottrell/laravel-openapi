<?php

use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Generator;
use Tests\Unit\Attributes\Stubs\StringableStub;

describe('Collection', function () {
    it('can fall back to default collection', function () {
        $collection = new Collection();
        expect($collection->name)->toBe([Generator::COLLECTION_DEFAULT]);
    });

    it('can accept string as collection name', function () {
        $collection = new Collection('collection');
        expect($collection->name)->toBe(['collection']);
    });

    it('can accept array of strings as collection name', function () {
        $collection = new Collection(['collection1', 'collection2']);
        expect($collection->name)->toBe(['collection1', 'collection2']);
    });

    it('can accept array of stringables as collection name', function () {
        $collection = new Collection([StringableStub::class]);
        expect($collection->name)->toBe(['stringable']);
    });

    it('can accept mixed array of strings and stringables as collection name', function () {
        $collection = new Collection(['collection', StringableStub::class]);
        expect($collection->name)->toBe(['collection', 'stringable']);
    });
})->covers(Collection::class);
