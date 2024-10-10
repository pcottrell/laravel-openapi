<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Not;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Not::class)]
class NotTest extends UnitTestCase
{
    public function testAsResponseWork(): void
    {
        $not = Not::create()
            ->schema(Schema::string('test'));

        $mediaType = MediaType::json()
            ->schema($not);

        $this->assertSame([
            'schema' => [
                'not' => [
                    'type' => 'string',
                ],
            ],
        ], $mediaType->jsonSerialize());
    }
}
