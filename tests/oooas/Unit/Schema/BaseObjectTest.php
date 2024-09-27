<?php

use MohammadAlavi\LaravelOpenApi\oooas\Schema\BaseObject;
use Tests\oooas\Doubles\Fakes\BaseObjectFake;

describe('BaseObject', function (): void {
    it('can be statically created', function (string|null $objectId, array $expectation): void {
        $object = BaseObjectFake::create($objectId);

        expect($object)->toBeInstanceOf(BaseObject::class)
            ->and($object->jsonSerialize())->toBe($expectation);
    })->with([
        'null' => [null, []],
        'empty' => ['', ['objectId' => '']],
        'test' => ['test', ['objectId' => 'test']],
    ]);

    it('can be statically created with ref method', function (): void {
        $object = BaseObjectFake::ref('test');

        $result = $object->ref;

        expect($result)->toBe('test');
    });

    it('can be json serializable', function (): void {
        expect(BaseObject::class)->toImplement(JsonSerializable::class);

        $object = BaseObjectFake::create();

        $result = $object->jsonSerialize();

        expect($result)->toBe([]);

        $object = BaseObjectFake::ref('test');

        $result = $object->jsonSerialize();

        expect($result)->toBe(['$ref' => 'test']);
    });
})->covers(BaseObject::class);
