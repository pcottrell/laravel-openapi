<?php

use MohammadAlavi\ObjectOrientedJSONSchema\Formats\StringFormat;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptors\StringDescriptor;

describe(class_basename(StringDescriptor::class), function (): void {
    it(
        'should return string schema with password format',
        function (StringFormat $stringFormat): void {
            $stringDescriptor = StringDescriptor::create()
                ->format($stringFormat)
                ->maxLength(10)
                ->minLength(5)
                ->pattern('^[a-zA-Z0-9]*$');

            expect($stringDescriptor->asArray())->toBe([
                'type' => 'string',
                'format' => $stringFormat->value,
                'maxLength' => 10,
                'minLength' => 5,
                'pattern' => '^[a-zA-Z0-9]*$',
            ]);
        },
    )->with(
        StringFormat::cases(),
    );
})->covers(StringDescriptor::class);
