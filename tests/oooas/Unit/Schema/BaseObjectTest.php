<?php

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\JsonSerializable;
use Tests\oooas\Doubles\Fakes\JsonSerializableFake;

describe('BaseObject', function (): void {
    it('can be json serializable', function (): void {
        expect(JsonSerializable::class)->toImplement(JsonSerializable::class);

        $object = new JsonSerializableFake();

        $result = $object->jsonSerialize();

        expect($result)->toBe([]);
    });
})->covers(JsonSerializable::class);
