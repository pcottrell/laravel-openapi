<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedJSONSchema\Schema;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\AllOf;

describe(class_basename(AllOf::class), function (): void {
    it('can be created', function (): void {
        $schema1 = Schema::string();
        $schema2 = Schema::integer();

        $allOf = AllOf::create('test')
            ->schemas($schema1, $schema2);

        expect($allOf->asArray())->toBe([
            'allOf' => [
                [
                    'type' => 'string',
                ],
                [
                    'type' => 'integer',
                ],
            ],
        ]);
    });
})->covers(AllOf::class);
