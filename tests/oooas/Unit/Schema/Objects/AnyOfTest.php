<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedJSONSchema\Review\Schema;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\AnyOf;

describe(class_basename(AnyOf::class), function (): void {
    it('can be created with all parameters', function (): void {
        $schema1 = Schema::string();
        $schema2 = Schema::integer();

        $anyOf = AnyOf::create('test')
            ->schemas($schema1, $schema2);

        expect($anyOf->asArray())->toBe([
            'anyOf' => [
                [
                    'type' => 'string',
                ],
                [
                    'type' => 'integer',
                ],
            ],
        ]);
    });
})->covers(AnyOf::class);
