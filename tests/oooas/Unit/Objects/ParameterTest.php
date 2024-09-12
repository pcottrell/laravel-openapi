<?php

use MohammadAlavi\ObjectOrientedOAS\Objects\Example;
use MohammadAlavi\ObjectOrientedOAS\Objects\MediaType;
use MohammadAlavi\ObjectOrientedOAS\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;

describe('Parameter', function (): void {
    it('can be instantiated with no parameters', function (): void {
        $parameter = Parameter::create();
        expect($parameter->name)->toBeNull()
            ->and($parameter->in)->toBeNull()
            ->and($parameter->description)->toBeNull()
            ->and($parameter->required)->toBeNull()
            ->and($parameter->deprecated)->toBeNull()
            ->and($parameter->allowEmptyValue)->toBeNull()
            ->and($parameter->style)->toBeNull()
            ->and($parameter->explode)->toBeNull()
            ->and($parameter->allowReserved)->toBeNull()
            ->and($parameter->schema)->toBeNull()
            ->and($parameter->example)->toBeNull()
            ->and($parameter->examples)->toBeNull()
            ->and($parameter->content)->toBeNull();
    });

    it('can be instantiated with all parameters', function (): void {
        $parameter = Parameter::create()
            ->name('user')
            ->in(Parameter::IN_PATH)
            ->description('User ID')
            ->required()
            ->deprecated()
            ->allowEmptyValue()
            ->style(Parameter::STYLE_SIMPLE)
            ->explode()
            ->allowReserved()
            ->schema(Schema::string())
            ->example(Example::create())
            ->examples(Example::create('ExampleName'))
            ->content(MediaType::json());

        expect($parameter->name)->toBe('user')
            ->and($parameter->in)->toBe(Parameter::IN_PATH)
            ->and($parameter->description)->toBe('User ID')
            ->and($parameter->required)->toBeTrue()
            ->and($parameter->deprecated)->toBeTrue()
            ->and($parameter->allowEmptyValue)->toBeTrue()
            ->and($parameter->style)->toBe(Parameter::STYLE_SIMPLE)
            ->and($parameter->explode)->toBeTrue()
            ->and($parameter->allowReserved)->toBeTrue()
            ->and($parameter->schema)->toBeInstanceOf(Schema::class)
            ->and($parameter->example)->toBeInstanceOf(Example::class)
            ->and($parameter->examples)->toBeArray()
            ->and($parameter->content)->toBeArray()
            ->and($parameter->content[0])->toBeInstanceOf(MediaType::class);
    });

    it('can be instantiated with all combinations', function (string $method, string $expectedType): void {
        $parameter = Parameter::$method();
        expect($parameter->in)->toBe($expectedType);
    })->with([
        'query' => ['query', Parameter::IN_QUERY],
        'header' => ['header', Parameter::IN_HEADER],
        'path' => ['path', Parameter::IN_PATH],
        'cookie' => ['cookie', Parameter::IN_COOKIE],
    ])->with([
        'objectId' => ['objectId'],
    ])->with([
        'style matrix' => ['style', Parameter::STYLE_MATRIX],
        'style label' => ['label', Parameter::STYLE_LABEL],
        'style form' => ['form', Parameter::STYLE_FORM],
        'style simple' => ['simple', Parameter::STYLE_SIMPLE],
        'style spaceDelimited' => ['spaceDelimited', Parameter::STYLE_SPACE_DELIMITED],
        'style pipeDelimited' => ['pipeDelimited', Parameter::STYLE_PIPE_DELIMITED],
        'style deepObject' => ['deepObject', Parameter::STYLE_DEEP_OBJECT],
    ]);

    it('can be generated', function (): void {
        $parameter = Parameter::create()
            ->name('user')
            ->in(Parameter::IN_PATH)
            ->description('User ID')
            ->required()
            ->deprecated()
            ->allowEmptyValue()
            ->style(Parameter::STYLE_SIMPLE)
            ->explode()
            ->allowReserved()
            ->schema(Schema::string())
            ->example(Example::create())
            ->examples(Example::create('ExampleName'))
            ->content(MediaType::json());

        expect($parameter->toArray())->toEqual([
            'name' => 'user',
            'in' => 'path',
            'description' => 'User ID',
            'required' => true,
            'deprecated' => true,
            'allowEmptyValue' => true,
            'style' => 'simple',
            'explode' => true,
            'allowReserved' => true,
            'schema' => [
                'type' => 'string',
            ],
            'example' => [],
            'examples' => [
                'ExampleName' => [],
            ],
            'content' => [
                'application/json' => [],
            ],
        ]);
    });
})->covers(Parameter::class);