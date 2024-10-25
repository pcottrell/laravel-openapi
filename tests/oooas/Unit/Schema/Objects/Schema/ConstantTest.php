<?php

use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Constant;

describe(class_basename(Constant::class), function (): void {
    it('should return constant value as is', function (mixed $value): void {
        $schema = Constant::create($value);

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
})->covers(Constant::class);
