<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OneOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Schema;

describe(class_basename(OneOf::class), function (): void {
    it('can be created with all parameters', function (): void {
        $schema1 = Schema::string();
        $schema2 = Schema::integer();

        $oneOf = OneOf::create('test')
            ->schemas($schema1, $schema2);

        expect($oneOf->asArray())->toBe([
            'oneOf' => [
                [
                    'type' => 'string',
                ],
                [
                    'type' => 'integer',
                ],
            ],
        ]);
    });
})->covers(OneOf::class);
