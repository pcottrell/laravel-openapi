<?php

use MohammadAlavi\LaravelOpenApi\oooas\Schema\BaseObject;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\NonExtensibleObject;
use Tests\oooas\Doubles\Fakes\NonExtensibleObjectFake;

describe('NonExtensibleObject', function (): void {
    it('can be created', function (): void {
        $nonExtensibleObjectFake = NonExtensibleObjectFake::create();

        expect($nonExtensibleObjectFake)->toBeInstanceOf(BaseObject::class);
    });
})->covers(NonExtensibleObject::class);
