<?php

use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptors\ConstantDescriptor;

describe(class_basename(ConstantDescriptor::class), function (): void {
    it('should return constant value as is', function (mixed $value): void {
        $schema = ConstantDescriptor::create($value);

        expect($schema->asArray())->toBe([
            'const' => $value,
        ]);
    })->with([
        'test',
        1,
        true,
        null,
        false,
    ]);
})->covers(ConstantDescriptor::class);
