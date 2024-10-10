<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\AnyOf;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\MediaType;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(AnyOf::class)]
class AnyOfTest extends UnitTestCase
{
    public function testTwoSchemasWork(): void
    {
        $schema1 = Schema::string('string_test');
        $schema2 = Schema::integer('integer_test');

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
        ], $anyOf->jsonSerialize());
    }

    public function testTwoSchemasAsResponseWork(): void
    {
        $schema1 = Schema::string('string_test');
        $schema2 = Schema::integer('integer_test');

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
        ], $mediaType->jsonSerialize());
    }
}
