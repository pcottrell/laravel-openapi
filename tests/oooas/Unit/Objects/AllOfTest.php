<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\AllOf;
use MohammadAlavi\ObjectOrientedOAS\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(AllOf::class)]
class AllOfTest extends UnitTestCase
{
    public function testTwoSchemasWork(): void
    {
        $schema1 = Schema::string();
        $schema2 = Schema::integer();

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
        ], $allOf->toArray());
    }

    public function testTwoSchemasAsResponseWork(): void
    {
        $schema1 = Schema::string();
        $schema2 = Schema::integer();

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
        ], $mediaType->toArray());
    }
}