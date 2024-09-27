<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\MediaType;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\OneOf;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;
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
        ], $oneOf->jsonSerialize());
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
        ], $mediaType->jsonSerialize());
    }
}
