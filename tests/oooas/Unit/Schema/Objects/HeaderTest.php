<?php

namespace Tests\oooas\Unit\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Example;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Header;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;

describe(class_basename(Header::class), function (): void {
    it('can be created with all parameters', function (): void {
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
            ->examples(Example::create('ExampleName'))
            ->content(MediaType::json());

        $response = $header->jsonSerialize();

        expect($response)->toBe([
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
        ]);
    });
})->covers(Header::class);
