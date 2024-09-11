<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\Example;
use MohammadAlavi\ObjectOrientedOAS\Objects\MediaType;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Example::class)]
class ExampleTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks()
    {
        $example = Example::create()
            ->summary('Summary ipsum')
            ->description('Description ipsum')
            ->value('Value')
            ->externalValue('https://goldspecdigital.com/example.json');

        $mediaType = MediaType::json()
            ->example($example);

        $this->assertSame([
            'example' => [
                'summary' => 'Summary ipsum',
                'description' => 'Description ipsum',
                'value' => 'Value',
                'externalValue' => 'https://goldspecdigital.com/example.json',
            ],
        ], $mediaType->toArray());
    }
}
