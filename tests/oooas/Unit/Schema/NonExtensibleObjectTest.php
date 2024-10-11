<?php

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\NonExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\JsonSerializable;
use Tests\oooas\Doubles\Fakes\NonExtensibleObjectFake;

describe('NonExtensibleObject', function (): void {
    it('can be created', function (): void {
        expect(NonExtensibleObjectFake::class)
            ->toExtend(JsonSerializable::class);
    });
})->covers(NonExtensibleObject::class);
