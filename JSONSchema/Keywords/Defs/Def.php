<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Defs;

use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptor;

final readonly class Def
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

    public function value(): Descriptor
    {
        return $this->schema;
    }
}
