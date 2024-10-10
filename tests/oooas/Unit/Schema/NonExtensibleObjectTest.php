<?php

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\BaseObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\NonExtensibleObject;
use Tests\oooas\Doubles\Fakes\NonExtensibleObjectFake;

describe('NonExtensibleObject', function (): void {
    it('can be created', function (): void {
        expect(NonExtensibleObjectFake::class)
            ->toExtend(BaseObject::class);
    });
})->covers(NonExtensibleObject::class);
