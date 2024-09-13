<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use MohammadAlavi\ObjectOrientedOAS\Objects\Discriminator;

describe('Discriminator', function (): void {
    it('can be created with no parameters', function (): void {
        $discriminator = Discriminator::create();

        expect($discriminator->toArray())->toBeEmpty();
    });

    it('can be created with all parameters', function (): void {
        $discriminator = Discriminator::create()
            ->propertyName('Discriminator Name')
            ->mapping(['key' => 'value']);

        expect($discriminator->toArray())->toBe([
            'propertyName' => 'Discriminator Name',
            'mapping' => [
                'key' => 'value',
            ],
        ]);
    });

    it('throws an exception when mapping is not an [string => string] array', function (array $mapping): void {
        expect(function () use ($mapping): void {
            Discriminator::create()->mapping($mapping);
        })->toThrow(InvalidArgumentException::class, 'Each mapping must have a string key and a string value.');
    })->with([
        'no string key' => [[1 => 'value']],
        'no string value' => [['key' => 1]],
    ]);

    it('will have no mapping if an empty array is passed', function (): void {
        $discriminator = Discriminator::create()->mapping([]);

        expect($discriminator->toArray())->toBeEmpty();
    });

    it('can be create with default (no mapping) mapping', function (): void {
        $discriminator = Discriminator::create();

        expect($discriminator->toArray())->toBeEmpty();
    });
})->covers(Discriminator::class);
