<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOAS\Objects\OneOf;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(OneOf::class)]
class OneOfTest extends UnitTestCase
{
    public function testTwoSchemasWork(): void
    {
        $schema1 = Schema::string();
        $schema2 = Schema::integer();

        $oneOf = OneOf::create()
            ->schemas($schema1, $schema2);

        $this->assertSame([
            'oneOf' => [
                [
                    'type' => 'string',
                ],
                [
                    'type' => 'integer',
                ],
            ],
        ], $oneOf->toArray());
    }

    public function testTwoSchemasAsResponseWork(): void
    {
        $schema1 = Schema::string();
        $schema2 = Schema::integer();

        $oneOf = OneOf::create()
            ->schemas($schema1, $schema2);

        $mediaType = MediaType::json()
            ->schema($oneOf);

        $this->assertSame([
            'schema' => [
                'oneOf' => [
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
