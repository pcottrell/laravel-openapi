<?php

use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptors\EnumDescriptor;

describe(class_basename(EnumDescriptor::class), function (): void {
    it('should return enum values as is', function (): void {
        $enumDescriptor = EnumDescriptor::create('test', 1, true, null, false);

        expect($enumDescriptor->asArray())->toBe([
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
