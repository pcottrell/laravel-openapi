<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Encoding;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Example;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Header;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(Encoding::class)]
class EncodingTest extends UnitTestCase
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
            ->schema(Schema::string('test'))
            ->example('Example String')
            ->examples(
                Example::create('ExampleName')
                    ->value('Example value'),
            )
            ->content(MediaType::json());

        $encoding = Encoding::create('EncodingName')
            ->contentType('application/json')
            ->headers($header)
            ->style('simple')
            ->explode()
            ->allowReserved();

        $mediaType = MediaType::json()
            ->encoding($encoding);

        $this->assertEquals([
            'encoding' => [
                'EncodingName' => [
                    'contentType' => 'application/json',
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
                                'type' => 'string',
                            ],
                            'example' => 'Example String',
                            'examples' => [
                                'ExampleName' => [
                                    'value' => 'Example value',
                                ],
                            ],
                            'content' => [
                                'application/json' => [],
                            ],
                        ],
                    ],
                    'style' => 'simple',
                    'explode' => true,
                    'allowReserved' => true,
                ],
            ],
        ], $mediaType->asArray());
    }
}
