<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Schema extends BaseObject implements SchemaContract
{
    public const TYPE_ARRAY = 'array';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_NUMBER = 'number';
    public const TYPE_OBJECT = 'object';
    public const TYPE_STRING = 'string';
    public const FORMAT_INT32 = 'int32';
    public const FORMAT_INT64 = 'int64';
    public const FORMAT_FLOAT = 'float';
    public const FORMAT_DOUBLE = 'double';
    public const FORMAT_BYTE = 'byte';
    public const FORMAT_BINARY = 'binary';
    public const FORMAT_DATE = 'date';
    public const FORMAT_DATE_TIME = 'date-time';
    public const FORMAT_PASSWORD = 'password';
    public const FORMAT_UUID = 'uuid';

    protected string|null $title = null;
    protected string|null $description = null;
    protected array|null $enum = null;
    protected mixed $default = null;
    protected string|null $format = null;
    protected string|null $type = null;
    protected SchemaContract|null $items = null;
    protected int|null $maxItems = null;
    protected int|null $minItems = null;
    protected bool|null $uniqueItems = null;
    protected string|null $pattern = null;
    protected int|null $maxLength = null;
    protected int|null $minLength = null;
    protected float|int|null $maximum = null;
    protected float|int|null $exclusiveMaximum = null;
    protected float|int|null $minimum = null;
    protected float|int|null $exclusiveMinimum = null;
    protected float|int|null $multipleOf = null;

    /** @var string[]|null */
    protected array|null $required = null;

    /** @var SchemaContract[]|null */
    protected array|null $properties = null;

    protected SchemaContract|null $additionalProperties = null;
    protected int|null $maxProperties = null;
    protected int|null $minProperties = null;
    protected bool|null $nullable = null;
    protected Discriminator|null $discriminator = null;
    protected bool|null $readOnly = null;
    protected bool|null $writeOnly = null;
    protected Xml|null $xml = null;
    protected ExternalDocs|null $externalDocs = null;
    protected mixed $example = null;
    protected bool|null $deprecated = null;

    public static function array(string|null $objectId = null): static
    {
        return static::create($objectId)->type(static::TYPE_ARRAY);
    }

    public function type(string|null $type): static
    {
        $instance = clone $this;

        $instance->type = $type;

        return $instance;
    }

    public static function boolean(string|null $objectId = null): static
    {
        return static::create($objectId)->type(static::TYPE_BOOLEAN);
    }

    public static function integer(string|null $objectId = null): static
    {
        return static::create($objectId)->type(static::TYPE_INTEGER);
    }

    public static function number(string|null $objectId = null): static
    {
        return static::create($objectId)->type(static::TYPE_NUMBER);
    }

    public static function object(string|null $objectId = null): static
    {
        return static::create($objectId)->type(static::TYPE_OBJECT);
    }

    public static function string(string|null $objectId = null): static
    {
        return static::create($objectId)->type(static::TYPE_STRING);
    }

    public function title(string|null $title): static
    {
        $instance = clone $this;

        $instance->title = $title;

        return $instance;
    }

    public function description(string|null $description): static
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    public function enum(...$enum): static
    {
        $instance = clone $this;

        $instance->enum = [] !== $enum ? $enum : null;

        return $instance;
    }

    public function default(mixed $default): static
    {
        $instance = clone $this;

        $instance->default = $default;

        return $instance;
    }

    public function format(string|null $format): static
    {
        $instance = clone $this;

        $instance->format = $format;

        return $instance;
    }

    public function items(SchemaContract $schemaContract): static
    {
        $instance = clone $this;

        $instance->items = $schemaContract;

        return $instance;
    }

    public function maxItems(int|null $maxItems): static
    {
        $instance = clone $this;

        $instance->maxItems = $maxItems;

        return $instance;
    }

    public function minItems(int|null $minItems): static
    {
        $instance = clone $this;

        $instance->minItems = $minItems;

        return $instance;
    }

    public function uniqueItems(bool|null $uniqueItems = true): static
    {
        $instance = clone $this;

        $instance->uniqueItems = $uniqueItems;

        return $instance;
    }

    public function pattern(string|null $pattern): static
    {
        $instance = clone $this;

        $instance->pattern = $pattern;

        return $instance;
    }

    public function maxLength(int|null $maxLength): static
    {
        $instance = clone $this;

        $instance->maxLength = $maxLength;

        return $instance;
    }

    public function minLength(int|null $minLength): static
    {
        $instance = clone $this;

        $instance->minLength = $minLength;

        return $instance;
    }

    public function maximum(float|int|null $maximum): static
    {
        $instance = clone $this;

        $instance->maximum = $maximum;

        return $instance;
    }

    public function exclusiveMaximum(float|int|null $exclusiveMaximum): static
    {
        $instance = clone $this;

        $instance->exclusiveMaximum = $exclusiveMaximum;

        return $instance;
    }

    public function minimum(float|int|null $minimum): static
    {
        $instance = clone $this;

        $instance->minimum = $minimum;

        return $instance;
    }

    public function exclusiveMinimum(float|int|null $exclusiveMinimum): static
    {
        $instance = clone $this;

        $instance->exclusiveMinimum = $exclusiveMinimum;

        return $instance;
    }

    public function multipleOf(float|int|null $multipleOf): static
    {
        $instance = clone $this;

        $instance->multipleOf = $multipleOf;

        return $instance;
    }

    public function required(self|string ...$required): static
    {
        foreach ($required as &$require) {
            if ($require instanceof self) {
                $require = $require->objectId;
            }
        }

        $instance = clone $this;

        $instance->required = [] !== $required ? $required : null;

        return $instance;
    }

    public function properties(SchemaContract ...$schemaContract): static
    {
        $instance = clone $this;

        $instance->properties = [] !== $schemaContract ? $schemaContract : null;

        return $instance;
    }

    public function additionalProperties(self|null $additionalProperties): static
    {
        $instance = clone $this;

        $instance->additionalProperties = $additionalProperties;

        return $instance;
    }

    public function maxProperties(int|null $maxProperties): static
    {
        $instance = clone $this;

        $instance->maxProperties = $maxProperties;

        return $instance;
    }

    public function minProperties(int|null $minProperties): static
    {
        $instance = clone $this;

        $instance->minProperties = $minProperties;

        return $instance;
    }

    public function nullable(bool|null $nullable = true): static
    {
        $instance = clone $this;

        $instance->nullable = $nullable;

        return $instance;
    }

    public function discriminator(Discriminator|null $discriminator): static
    {
        $instance = clone $this;

        $instance->discriminator = $discriminator;

        return $instance;
    }

    public function readOnly(bool|null $readOnly = true): static
    {
        $instance = clone $this;

        $instance->readOnly = $readOnly;

        return $instance;
    }

    public function writeOnly(bool|null $writeOnly = true): static
    {
        $instance = clone $this;

        $instance->writeOnly = $writeOnly;

        return $instance;
    }

    public function xml(Xml|null $xml): static
    {
        $instance = clone $this;

        $instance->xml = $xml;

        return $instance;
    }

    public function externalDocs(ExternalDocs|null $externalDocs): static
    {
        $instance = clone $this;

        $instance->externalDocs = $externalDocs;

        return $instance;
    }

    public function example(mixed $example): static
    {
        $instance = clone $this;

        $instance->example = $example;

        return $instance;
    }

    public function deprecated(bool|null $deprecated = true): static
    {
        $instance = clone $this;

        $instance->deprecated = $deprecated;

        return $instance;
    }

    protected function generate(): array
    {
        $properties = [];
        foreach ($this->properties ?? [] as $property) {
            $properties[$property->objectId] = $property->toArray();
        }

        return Arr::filter([
            'title' => $this->title,
            'description' => $this->description,
            'enum' => $this->enum,
            'default' => $this->default,
            'format' => $this->format,
            'type' => $this->type,
            'items' => $this->items,
            'maxItems' => $this->maxItems,
            'minItems' => $this->minItems,
            'uniqueItems' => $this->uniqueItems,
            'pattern' => $this->pattern,
            'maxLength' => $this->maxLength,
            'minLength' => $this->minLength,
            'maximum' => $this->maximum,
            'exclusiveMaximum' => $this->exclusiveMaximum,
            'minimum' => $this->minimum,
            'exclusiveMinimum' => $this->exclusiveMinimum,
            'multipleOf' => $this->multipleOf,
            'required' => $this->required,
            'properties' => [] !== $properties ? $properties : null,
            'additionalProperties' => $this->additionalProperties,
            'maxProperties' => $this->maxProperties,
            'minProperties' => $this->minProperties,
            'nullable' => $this->nullable,
            'discriminator' => $this->discriminator,
            'readOnly' => $this->readOnly,
            'writeOnly' => $this->writeOnly,
            'xml' => $this->xml,
            'externalDocs' => $this->externalDocs,
            'example' => $this->example,
            'deprecated' => $this->deprecated,
        ]);
    }
}
