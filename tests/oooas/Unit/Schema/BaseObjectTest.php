<?php

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generatable;
use Tests\oooas\Doubles\Fakes\GeneratableFake;

describe('BaseObject', function (): void {
    it('can be json serializable', function (): void {
        expect(Generatable::class)->toImplement(Generatable::class);

        $object = new GeneratableFake();

        $result = $object->jsonSerialize();

        expect($result)->toBe([]);
    });
})->covers(Generatable::class);
