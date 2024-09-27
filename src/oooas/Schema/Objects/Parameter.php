<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Parameter extends ExtensibleObject
{
    public const IN_QUERY = 'query';
    public const IN_HEADER = 'header';
    public const IN_PATH = 'path';
    public const IN_COOKIE = 'cookie';
    public const STYLE_MATRIX = 'matrix';
    public const STYLE_LABEL = 'label';
    public const STYLE_FORM = 'form';
    public const STYLE_SIMPLE = 'simple';
    public const STYLE_SPACE_DELIMITED = 'spaceDelimited';
    public const STYLE_PIPE_DELIMITED = 'pipeDelimited';
    public const STYLE_DEEP_OBJECT = 'deepObject';

    protected string|null $name = null;
    protected string|null $in = null;
    protected string|null $description = null;
    protected bool|null $required = null;
    protected bool|null $deprecated = null;
    protected bool|null $allowEmptyValue = null;
    protected string|null $style = null;
    protected bool|null $explode = null;
    protected bool|null $allowReserved = null;
    protected SchemaContract|null $schema = null;
    protected mixed $example = null;

    /** @var Example[]|null */
    protected array|null $examples = null;

    /** @var MediaType[]|null */
    protected array|null $content = null;

    public static function query(string|null $objectId = null): static
    {
        return static::create($objectId)->in(static::IN_QUERY);
    }

    public function in(string|null $in): static
    {
        $instance = clone $this;

        $instance->in = $in;

        return $instance;
    }

    public static function header(string|null $objectId = null): static
    {
        return static::create($objectId)->in(static::IN_HEADER);
    }

    public static function path(string|null $objectId = null): static
    {
        return static::create($objectId)->in(static::IN_PATH);
    }

    public static function cookie(string|null $objectId = null): static
    {
        return static::create($objectId)->in(static::IN_COOKIE);
    }

    public function name(string|null $name): static
    {
        $instance = clone $this;

        $instance->name = $name;

        return $instance;
    }

    public function description(string|null $description): static
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    public function required(bool|null $required = true): static
    {
        $instance = clone $this;

        $instance->required = $required;

        return $instance;
    }

    public function deprecated(bool|null $deprecated = true): static
    {
        $instance = clone $this;

        $instance->deprecated = $deprecated;

        return $instance;
    }

    public function allowEmptyValue(bool|null $allowEmptyValue = true): static
    {
        $instance = clone $this;

        $instance->allowEmptyValue = $allowEmptyValue;

        return $instance;
    }

    public function style(string|null $style): static
    {
        $instance = clone $this;

        $instance->style = $style;

        return $instance;
    }

    public function explode(bool|null $explode = true): static
    {
        $instance = clone $this;

        $instance->explode = $explode;

        return $instance;
    }

    public function allowReserved(bool|null $allowReserved = true): static
    {
        $instance = clone $this;

        $instance->allowReserved = $allowReserved;

        return $instance;
    }

    public function schema(SchemaContract|null $schema): static
    {
        $instance = clone $this;

        $instance->schema = $schema;

        return $instance;
    }

    public function example(mixed $example): static
    {
        $instance = clone $this;

        $instance->example = $example;

        return $instance;
    }

    public function examples(Example ...$example): static
    {
        $instance = clone $this;

        $instance->examples = [] !== $example ? $example : null;

        return $instance;
    }

    public function content(MediaType ...$mediaType): static
    {
        $instance = clone $this;

        $instance->content = [] !== $mediaType ? $mediaType : null;

        return $instance;
    }

    protected function toArray(): array
    {
        $examples = [];
        foreach ($this->examples ?? [] as $example) {
            $examples[$example->objectId] = $example->jsonSerialize();
        }

        $content = [];
        foreach ($this->content ?? [] as $contentItem) {
            $content[$contentItem->mediaType] = $contentItem;
        }

        return Arr::filter([
            'name' => $this->name,
            'in' => $this->in,
            'description' => $this->description,
            'required' => $this->required,
            'deprecated' => $this->deprecated,
            'allowEmptyValue' => $this->allowEmptyValue,
            'style' => $this->style,
            'explode' => $this->explode,
            'allowReserved' => $this->allowReserved,
            'schema' => $this->schema,
            'example' => $this->example,
            'examples' => [] !== $examples ? $examples : null,
            'content' => [] !== $content ? $content : null,
        ]);
    }
}
