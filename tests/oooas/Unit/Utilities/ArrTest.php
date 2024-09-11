<?php

namespace Tests\oooas\Unit\Utilities;

use MohammadAlavi\ObjectOrientedOAS\OpenApi;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Arr::class)]
class ArrTest extends UnitTestCase
{
    public function testNullValuesAreRemovedFromArray(): void
    {
        $array = ['test' => null];

        $array = Arr::filter($array);

        $this->assertCount(0, $array);
    }

    public function testNonNullValuesRemain(): void
    {
        $array = [
            'false' => false,
            '0' => 0,
            'string' => 'string',
            'object' => OpenApi::create(),
        ];

        $array = Arr::filter($array);

        $this->assertCount(4, $array);
        $this->assertArrayHasKey('false', $array);
        $this->assertArrayHasKey('0', $array);
        $this->assertArrayHasKey('string', $array);
        $this->assertArrayHasKey('object', $array);
    }
}
