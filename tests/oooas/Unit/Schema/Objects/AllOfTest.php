<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\AllOf;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(AllOf::class)]
class AllOfTest extends UnitTestCase
{
    public function testTwoSchemasWork(): void
    {
        $schema1 = Schema::string('string_test');
        $schema2 = Schema::integer('integer_test');

        $allOf = AllOf::create()
            ->schemas($schema1, $schema2);

        $this->assertSame([
            'allOf' => [
                [
                    'type' => 'string',
                ],
                [
                    'type' => 'integer',
                ],
            ],
        ], $allOf->jsonSerialize());
    }

    public function testTwoSchemasAsResponseWork(): void
    {
        $schema1 = Schema::string('string_test');
        $schema2 = Schema::integer('integer_test');

        $allOf = AllOf::create()
            ->schemas($schema1, $schema2);

        $mediaType = MediaType::json()
            ->schema($allOf);

        $this->assertSame([
            'schema' => [
                'allOf' => [
                    [
                        'type' => 'string',
                    ],
                    [
                        'type' => 'integer',
                    ],
                ],
            ],
        ], $mediaType->jsonSerialize());
    }
}
