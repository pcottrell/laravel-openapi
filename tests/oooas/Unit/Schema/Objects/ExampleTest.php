<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Example;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\MediaType;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Example::class)]
class ExampleTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $example = Example::create()
            ->summary('Summary ipsum')
            ->description('Description ipsum')
            ->value('Value')
            ->externalValue('https://example.com/example.json');

        $mediaType = MediaType::json()
            ->example($example);

        $this->assertSame([
            'example' => [
                'summary' => 'Summary ipsum',
                'description' => 'Description ipsum',
                'value' => 'Value',
                'externalValue' => 'https://example.com/example.json',
            ],
        ], $mediaType->jsonSerialize());
    }
}
