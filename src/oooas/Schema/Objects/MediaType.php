<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class MediaType extends ExtensibleObject
{
    public const MEDIA_TYPE_APPLICATION_JSON = 'application/json';
    public const MEDIA_TYPE_APPLICATION_PDF = 'application/pdf';
    public const MEDIA_TYPE_IMAGE_JPEG = 'image/jpeg';
    public const MEDIA_TYPE_IMAGE_PNG = 'image/png';
    public const MEDIA_TYPE_TEXT_CALENDAR = 'text/calendar';
    public const MEDIA_TYPE_TEXT_PLAIN = 'text/plain';
    public const MEDIA_TYPE_TEXT_XML = 'text/xml';
    public const MEDIA_TYPE_APPLICATION_X_WWW_FORM_URLENCODED = 'application/x-www-form-urlencoded';

    protected string|null $mediaType = null;
    protected SchemaContract|null $schema = null;
    protected Example|null $example = null;

    /** @var Example[]|null */
    protected array|null $examples = null;

    /** @var Encoding[]|null */
    protected array|null $encoding = null;

    public static function json(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->mediaType(static::MEDIA_TYPE_APPLICATION_JSON);
    }

    public function mediaType(string|null $mediaType): static
    {
        $clone = clone $this;

        $clone->mediaType = $mediaType;

        return $clone;
    }

    public static function pdf(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->mediaType(static::MEDIA_TYPE_APPLICATION_PDF);
    }

    public static function jpeg(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->mediaType(static::MEDIA_TYPE_IMAGE_JPEG);
    }

    public static function png(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->mediaType(static::MEDIA_TYPE_IMAGE_PNG);
    }

    public static function calendar(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->mediaType(static::MEDIA_TYPE_TEXT_CALENDAR);
    }

    public static function plainText(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->mediaType(static::MEDIA_TYPE_TEXT_PLAIN);
    }

    public static function xml(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->mediaType(static::MEDIA_TYPE_TEXT_XML);
    }

    public static function formUrlEncoded(string|null $objectId = null): static
    {
        return static::create($objectId)
            ->mediaType(static::MEDIA_TYPE_APPLICATION_X_WWW_FORM_URLENCODED);
    }

    public function schema(SchemaContract|null $schema): static
    {
        $clone = clone $this;

        $clone->schema = $schema;

        return $clone;
    }

    public function example(Example|null $example): static
    {
        $clone = clone $this;

        $clone->example = $example;

        return $clone;
    }

    public function examples(Example ...$example): static
    {
        $clone = clone $this;

        $clone->examples = [] !== $example ? $example : null;

        return $clone;
    }

    public function encoding(Encoding ...$encoding): static
    {
        $clone = clone $this;

        $clone->encoding = [] !== $encoding ? $encoding : null;

        return $clone;
    }

    protected function toArray(): array
    {
        $examples = [];
        foreach ($this->examples ?? [] as $example) {
            $examples[$example->objectId] = $example->jsonSerialize();
        }

        $encodings = [];
        foreach ($this->encoding ?? [] as $encoding) {
            $encodings[$encoding->objectId] = $encoding->jsonSerialize();
        }

        return Arr::filter([
            'schema' => $this->schema,
            'example' => $this->example,
            'examples' => [] !== $examples ? $examples : null,
            'encoding' => [] !== $encodings ? $encodings : null,
        ]);
    }
}
