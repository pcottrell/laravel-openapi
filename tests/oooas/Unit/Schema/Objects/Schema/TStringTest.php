<?php

use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\String\FormatAnnotation\Format\StringFormat;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\String\StringDescriptor;

describe(class_basename(StringDescriptor::class), function (): void {
    it(
        'should return string schema with password format',
        function (StringFormat $format): void {
            $schema = StringDescriptor::create()
                ->format($format)
                ->maxLength(10)
                ->minLength(5)
                ->pattern('^[a-zA-Z0-9]*$');

            expect($schema->asArray())->toBe([
                'type' => 'string',
                'format' => $format->value,
                'maxLength' => 10,
                'minLength' => 5,
                'pattern' => '^[a-zA-Z0-9]*$',
            ]);
        },
    )->with(
        StringFormat::cases(),
    );
})->covers(StringDescriptor::class);
