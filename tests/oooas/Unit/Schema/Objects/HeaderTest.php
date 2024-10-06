<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Example;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Header;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\MediaType;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Response;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;
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
            ->schema(Schema::object())
            ->example('Example value')
            ->examples(Example::create())
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
