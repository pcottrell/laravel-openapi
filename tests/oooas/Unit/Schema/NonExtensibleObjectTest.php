<?php

use MohammadAlavi\LaravelOpenApi\oooas\Schema\BaseObject;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\NonExtensibleObject;
use Tests\oooas\Doubles\Fakes\NonExtensibleObjectFake;

describe('NonExtensibleObject', function (): void {
    it('can be created', function (): void {
        $object = NonExtensibleObjectFake::create();

        expect($object)->toBeInstanceOf(BaseObject::class);
    });
})->covers(NonExtensibleObject::class);
