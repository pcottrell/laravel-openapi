<?php

use MohammadAlavi\ObjectOrientedOAS\Exceptions\PropertyDoesNotExistException;
use MohammadAlavi\ObjectOrientedOAS\Objects\BaseObject;
use Tests\oooas\Stubs\BaseObjectStub;

describe('BaseObject', function (): void {
    it('can be created with objectId', function (): void {
        $object = BaseObjectStub::create('test');

        expect($object->toArray())->toBe([
            'objectId' => 'test',
        ]);
    });

    it('can be created with create method', function (): void {
        $object = BaseObjectStub::create('test');

        expect($object->toArray())->toBe([
            'objectId' => 'test',
        ]);
    });

    it('can be created with ref method', function (): void {
        $object = BaseObjectStub::ref('test');

        expect($object->toArray())->toBe([
            '$ref' => 'test',
        ]);
    });

    it('can set and get extensions', function (string $key, string $value, string $extensionKey, string $expectation): void {
        $object = BaseObjectStub::create()->x($key, $value);

        expect($object->x[$extensionKey])->toBe($expectation)
            ->and($object->$extensionKey)->toBe($expectation);
    })->with([
        'x-test' => ['x-test', 'value', 'x-test', 'value'],
        'test' => ['test', 'value', 'x-test', 'value'],
        'empty value' => ['test', '', 'x-test', ''],
        'just -x' => ['x-', 'value', 'x-', 'value'],
    ]);

    it('doest allow empty key', function (): void {
        expect(function (): void {
            BaseObjectStub::create()->x('', 'value');
        })->toThrow(InvalidArgumentException::class);
    });

    it('can access all extensions via x property', function (): void {
        $object = BaseObjectStub::create()->x('x-test', 'value');

        expect($object->x)->toBe(['x-test' => 'value']);
    });

    it('can add to extensions by using x method multiple times', function (): void {
        $object = BaseObjectStub::create()
            ->x('x-test', 'value')
            ->x('test2', 'value2')
            ->x('x-test3', 'value3');

        expect($object->toArray())->toBe([
            'x-test' => 'value',
            'x-test2' => 'value2',
            'x-test3' => 'value3',
        ]);
    });

    it('excludes extensions that has no value set', function (): void {
        $object = BaseObjectStub::create()->x('x-test');

        expect($object->toArray())->toBeEmpty();
    });

    it('can be converted to Json', function (): void {
        $object = BaseObjectStub::create('test');

        expect($object->toJson())->toBe('{"objectId":"test"}');
    });

    it('can be converted to Json with options', function (): void {
        $object = BaseObjectStub::create('test');

        expect($object->toJson(JSON_PRETTY_PRINT))->toBe('{
    "objectId": "test"
}');
    });

    it('can be json serialized', function (): void {
        $object = BaseObjectStub::create('test');

        expect($object->jsonSerialize())->toBe([
            'objectId' => 'test',
        ]);
    });

    it('has a magic getter', function (): void {
        $object = BaseObjectStub::create('test');

        expect($object->objectId)->toBe('test');
    });

    it('should throw an exception if property does not exist', function (): void {
        $object = BaseObjectStub::create('test');

        expect(static fn () => $object->nonExistingProperty)->toThrow(PropertyDoesNotExistException::class);
    });
})->covers(BaseObject::class);
