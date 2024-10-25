<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\FormatAnnotation\Format;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\FormatAnnotation;

final readonly class Format implements SchemaProperty, FormatAnnotation
{
    private function __construct(
        private DefinedFormat $definedFormat,
    ) {
    }

    public static function create(DefinedFormat $definedFormat): self
    {
        return new self($definedFormat);
    }

    public static function keyword(): string
    {
        return 'format';
    }

    public function value(): string
    {
        return $this->definedFormat->value();
    }
}
