<?php

use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Enum;

describe(class_basename(Enum::class), function (): void {
    it('should return enum values as is', function (): void {
        $schema = Enum::create('test', 1, true, null, false);

        expect($schema->asArray())->toBe([
            'enum' => [
                'test',
                1,
                true,
                null,
                false,
            ],
        ]);
    });
})->covers(Enum::class);
