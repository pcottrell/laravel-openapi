<?php

use MohammadAlavi\ObjectOrientedJSONSchema\SchemaBuilder;

describe(class_basename(SchemaBuilder::class), function (): void {
    it('should return constant value as is', function (mixed $value): void {
        $schemaBuilder = SchemaBuilder::create()->const($value);

        expect($schemaBuilder->jsonSerialize())->toBe([
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
})->covers(SchemaBuilder::class);
