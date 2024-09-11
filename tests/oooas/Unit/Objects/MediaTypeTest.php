<?php

namespace Tests\oooas\Unit\Objects;

use MohammadAlavi\ObjectOrientedOAS\Objects\Encoding;
use MohammadAlavi\ObjectOrientedOAS\Objects\Example;
use MohammadAlavi\ObjectOrientedOAS\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOAS\Objects\Response;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\UnitTestCase;

#[CoversClass(MediaType::class)]
class MediaTypeTest extends UnitTestCase
{
    public function testCreateWithAllParametersWorks()
    {
        $mediaType = MediaType::create()
            ->mediaType(MediaType::MEDIA_TYPE_APPLICATION_JSON)
            ->schema(Schema::object())
            ->examples(Example::create('ExampleName'))
            ->example(Example::create())
            ->encoding(Encoding::create('EncodingName'));

        $response = Response::create()
            ->content($mediaType);

        $this->assertEquals([
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                    ],
                    'examples' => [
                        'ExampleName' => [],
                    ],
                    'example' => [],
                    'encoding' => [
                        'EncodingName' => [],
                    ],
                ],
            ],
        ], $response->toArray());
    }

    public function testCreateExampleWithRefWorks()
    {
        $mediaType = MediaType::create()
            ->mediaType(MediaType::MEDIA_TYPE_APPLICATION_JSON)
            ->examples(
                Example::ref('#/components/examples/FrogExample', 'frog'),
            );

        $this->assertEquals([
            'examples' => [
                'frog' => [
                    '$ref' => '#/components/examples/FrogExample',
                ],
            ],
        ], $mediaType->toArray());
    }
}
