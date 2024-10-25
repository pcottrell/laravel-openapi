<?php

use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\EnumDescriptor;

describe(class_basename(EnumDescriptor::class), function (): void {
    it('should return enum values as is', function (): void {
        $schema = EnumDescriptor::create('test', 1, true, null, false);

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
})->covers(EnumDescriptor::class);
