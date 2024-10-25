<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Applicator\Object\Properties;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;

final readonly class Property
{
    private function __construct(
        private string $name,
        private Descriptor $schema,
    ) {
    }

    public static function create(string $name, Descriptor $schema): self
    {
        return new self($name, $schema);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function schema(): Descriptor
    {
        return $this->schema;
    }
}
