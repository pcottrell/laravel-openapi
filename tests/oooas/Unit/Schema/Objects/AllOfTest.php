<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedJSONSchema\Review\Schema;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\AllOf;

describe(class_basename(AllOf::class), function (): void {
    it('can be created', function (): void {
        $stringDescriptor = Schema::string();
        $integerDescriptor = Schema::integer();

        $allOf = AllOf::create('test')
            ->schemas($stringDescriptor, $integerDescriptor);

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
