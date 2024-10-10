<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Example;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Header;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Response;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Header::class)]
class HeaderTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks(): void
    {
        $header = Header::create('HeaderName')
            ->description('Lorem ipsum')
            ->required()
            ->deprecated()
            ->allowEmptyValue()
            ->style(Header::STYLE_SIMPLE)
            ->explode()
            ->allowReserved()
            ->schema(Schema::object('object_test'))
            ->example('Example value')
            ->examples(Example::create('example_test'))
            ->content(MediaType::json());

        $response = Response::create()
            ->headers($header);

        $this->assertEquals([
            'headers' => [
                'HeaderName' => [
                    'description' => 'Lorem ipsum',
                    'required' => true,
                    'deprecated' => true,
                    'allowEmptyValue' => true,
                    'style' => 'simple',
                    'explode' => true,
                    'allowReserved' => true,
                    'schema' => [
                        'type' => 'object',
                    ],
                    'example' => 'Example value',
                    'examples' => [
                        'ExampleName' => [],
                    ],
                    'content' => [
                        'application/json' => [],
                    ],
                ],
            ],
        ], $response->jsonSerialize());
    }
}
