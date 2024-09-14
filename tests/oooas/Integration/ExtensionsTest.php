<?php

namespace Tests\oooas\Unit\Utilities;

use MohammadAlavi\ObjectOrientedOAS\Exceptions\PropertyDoesNotExistException;
use MohammadAlavi\ObjectOrientedOAS\Objects\Components;
use MohammadAlavi\ObjectOrientedOAS\Objects\Operation;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;

describe('ExtensionsTest', function (): void {
    dataset('schemaDataSet', [
        [Components::class],
        [Operation::class],
        [PathItem::class],
        [Response::class],
        [Schema::class],
    ]);

    it('can create objects with extension', function (string $schema): void {
        $arraySchema = Schema::array()->items(Schema::string());
        $object = $schema::create()
            ->x('key', 'value')
            ->x('x-foo', 'bar')
            ->x('x-baz', null)
            ->x('x-array', $arraySchema);

        expect($object->toArray())->toBe([
            'x-key' => 'value',
            'x-foo' => 'bar',
            'x-baz' => null,
            'x-array' => $arraySchema,
        ])->and($object->toJson())->toBe('{"x-key":"value","x-foo":"bar","x-baz":null,"x-array":{"type":"array","items":{"type":"string"}}}');
    })->with('schemaDataSet');

    it('can unset extensions', function (): void {
        $object = Schema::create()
            ->x('key', 'value')
            ->x('x-foo', 'bar')
            ->x('x-baz', null);

        $object = $object->x('key');

        expect($object->toArray())->toBe([
            'x-foo' => 'bar',
            'x-baz' => null,
        ])->and($object->toJson())->toBe('{"x-foo":"bar","x-baz":null}');
    });

    it('gets single extension', function (string $schema): void {
        $object = $schema::create()->x('foo', 'bar');

        expect($object->{'x-foo'})->toBe('bar');
    })->with('schemaDataSet');

    it('GetSingleExtensionDoesNotExist', function (string $schema): void {
        expect(function () use ($schema): void {
            $object = $schema::create()->x('foo', 'bar');

            $object->{'x-key'};
        })->toThrow(PropertyDoesNotExistException::class, '[x-key] is not a valid property');
    })->with('schemaDataSet');

    it('gets all extensions', function (string $schema): void {
        $object = $schema::create();

        expect($object->x)->toBe([]);

        $object = $object
            ->x('key', 'value')
            ->x('foo', 'bar');

        expect($object->x)->toBe(['x-key' => 'value', 'x-foo' => 'bar']);
    })->with('schemaDataSet');

    it('throws exception when extension does not exist', function (string $schema): void {
        expect(function () use ($schema): void {
            $object = $schema::create();

            $object->{'x-key'};
        })->toThrow(PropertyDoesNotExistException::class, '[x-key] is not a valid property');
    })->with('schemaDataSet');
})->coversNothing();
