<?php

use MohammadAlavi\LaravelOpenApi\oooas\Schema\BaseObject;
use Tests\oooas\Doubles\Fakes\BaseObjectFake;

describe('BaseObject', function (): void {
    it('can be json serializable', function (): void {
        expect(BaseObject::class)->toImplement(JsonSerializable::class);

        $object = new BaseObjectFake();

        $result = $object->jsonSerialize();

        expect($result)->toBe([]);
    });
})->covers(BaseObject::class);
