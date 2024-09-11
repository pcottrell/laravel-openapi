<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\AnyOf;
use MohammadAlavi\ObjectOrientedOAS\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(AnyOf::class)]
class AnyOfTest extends UnitTestCase
{
    public function testTwoSchemasWork(): void
    {
        $schema1 = Schema::string();
        $schema2 = Schema::integer();

        $anyOf = AnyOf::create()
            ->schemas($schema1, $schema2);

        $this->assertSame([
            'anyOf' => [
                [
                    'type' => 'string',
                ],
                [
                    'type' => 'integer',
                ],
            ],
        ], $anyOf->toArray());
    }

    public function testTwoSchemasAsResponseWork(): void
    {
        $schema1 = Schema::string();
        $schema2 = Schema::integer();

        $anyOf = AnyOf::create()
            ->schemas($schema1, $schema2);

        $mediaType = MediaType::json()
            ->schema($anyOf);

        $this->assertSame([
            'schema' => [
                'anyOf' => [
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
