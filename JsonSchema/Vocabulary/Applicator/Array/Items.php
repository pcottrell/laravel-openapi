<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Applicator\Array;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Applicator;

final readonly class Items implements SchemaProperty, Applicator
{
    private function __construct(
        private Descriptor $schema,
    ) {
    }

    public static function create(Descriptor $schema): self
    {
        return new self($schema);
    }

    public static function keyword(): string
    {
        return 'items';
    }

    public function value(): Descriptor
    {
        return $this->schema;
    }
}
