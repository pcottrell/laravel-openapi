<?php

use MohammadAlavi\LaravelOpenApi\oooas\Extensions\Extension;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Exceptions\PropertyDoesNotExistException;
use Tests\oooas\Stubs\ExtensibleObjectStub;

// TODO: rename tests
//  Also move irrelevant tests to the parent BaseObject
describe('ExtensibleObject', function (): void {
    it('can be created with objectId', function (): void {
        $object = ExtensibleObjectStub::create('test');

        $result = $object->serialize();

        expect($result)->toBe([
            'objectId' => 'test',
        ]);
    });

    it('can be created with create method', function (): void {
        $object = ExtensibleObjectStub::create('test');

        $result = $object->serialize();

        expect($result)->toBe([
            'objectId' => 'test',
        ]);
    });

    it('can be created with ref method', function (): void {
        $object = ExtensibleObjectStub::ref('test');

        $result = $object->serialize();

        expect($result)->toBe([
            '$ref' => 'test',
        ]);
    });

    it('can set and get extensions', function (Extension $extension): void {
        $object = ExtensibleObjectStub::create()->addExtension($extension);

        $result = $object->getExtension($extension->name);

        expect($result->equals($extension))->toBeTrue();
    })->with([
        'x-test' => [Extension::create('x-test', 'value')],
        'just -x' => [Extension::create('x-', 'value')],
    ]);

    it('doest allow invalid key', function (string $key): void {
        expect(function () use ($key): void {
            ExtensibleObjectStub::create()->addExtension(Extension::create($key, 'value'));
        })->toThrow(InvalidArgumentException::class);
    })->with([
        'test' => ['test'],
        'empty' => [''],
        'just -' => ['-'],
    ]);

    it('can access all extensions via x property', function (): void {
        $extension = Extension::create('x-test', 'value');

        $result = ExtensibleObjectStub::create()->addExtension($extension);

        expect($result)->getExtension('x-test')->equals($extension)->toBeTrue();
    });

    it('can add to extensions by using x method multiple times', function (): void {
        $object = ExtensibleObjectStub::create()
            ->addExtension(Extension::create('x-test', 'value'))
            ->addExtension(
                Extension::create('x-test2', 'value2'),
            )->addExtension(Extension::create('x-test3', 'value3'));

        $result = $object->serialize();

        expect($result)->toBe([
            'x-test' => 'value',
            'x-test2' => 'value2',
            'x-test3' => 'value3',
        ]);
    });

    it('excludes extensions that has no value set', function (): void {
        $object = ExtensibleObjectStub::create()->addExtension(Extension::create('x-test', ''));

        $result = $object->serialize();

        expect($result)->toBeEmpty();
    })->skip('It seems empty values are valid in the spec.');

    it('can be json serialized', function (): void {
        $object = ExtensibleObjectStub::create('test');

        $result = $object->serialize();

        expect($result)->toBe([
            'objectId' => 'test',
        ]);
    });

    it('has a magic getter', function (): void {
        $object = ExtensibleObjectStub::create('test');

        $result = $object->objectId;

        expect($result)->toBe('test');
    });

    it('should throw an exception if property does not exist', function (): void {
        $object = ExtensibleObjectStub::create('test');

        expect(static fn () => $object->nonExistingProperty)->toThrow(PropertyDoesNotExistException::class);
    });
})->covers(ExtensibleObject::class);
