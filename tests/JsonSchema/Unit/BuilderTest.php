<?php

use MohammadAlavi\ObjectOrientedJSONSchema\Builder;

describe(class_basename(Builder::class), function (): void {
    it('should return constant value as is', function (mixed $value): void {
        $schema = Builder::create()->const($value);

        expect($schema->jsonSerialize())->toBe([
            '$schema' => 'http://json-schema.org/draft-2020-12/schema',
            'const' => $value,
        ]);
    })->with([
        'test',
        1,
        true,
        null,
        false,
    ]);
})->covers(Builder::class);
