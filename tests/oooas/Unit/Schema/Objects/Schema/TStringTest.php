<?php

use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\FormatAnnotation\Format\StringFormat;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\TString;

describe(class_basename(TString::class), function (): void {
    it(
        'should return string schema with password format',
        function (StringFormat $format): void {
            $schema = TString::create()
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
})->covers(TString::class);
