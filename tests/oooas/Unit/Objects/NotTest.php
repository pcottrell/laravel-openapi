<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOAS\Objects\Not;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Not::class)]
class NotTest extends UnitTestCase
{
    public function testAsResponseWork()
    {
        $not = Not::create()
            ->schema(Schema::string());

        $mediaType = MediaType::json()
            ->schema($not);

        $this->assertSame([
            'schema' => [
                'not' => [
                    'type' => 'string',
                ],
            ],
        ], $mediaType->toArray());
    }
}
