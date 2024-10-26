<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Applicators;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Applicator;

final readonly class AdditionalProperties implements SchemaProperty, Applicator
{
    private function __construct(
        private Descriptor|bool $schema,
    ) {
    }

    public static function create(Descriptor|bool $schema): self
    {
        return new self($schema);
    }

    public static function keyword(): string
    {
        return 'additionalProperties';
    }

    public function value(): Descriptor|bool
    {
        return $this->schema;
    }
}
