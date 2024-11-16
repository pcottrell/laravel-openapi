<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Properties;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;

final readonly class Property
{
    private function __construct(
        private string $name,
        private BuilderInterface $schema,
    ) {
    }

    public static function create(string $name, BuilderInterface $schema): self
    {
        return new self($name, $schema);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function schema(): BuilderInterface
    {
        return $this->schema;
    }
}
