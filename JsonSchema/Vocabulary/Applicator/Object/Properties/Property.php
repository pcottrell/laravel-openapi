<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Applicator\Object\Properties;

use MohammadAlavi\ObjectOrientedJSONSchema\Schema;

final readonly class Property
{
    private function __construct(
        private string $name,
        private Schema $schema,
    ) {
    }

    public static function create(string $name, Schema $schema): self
    {
        return new self($name, $schema);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function schema(): Schema
    {
        return $this->schema;
    }
}
