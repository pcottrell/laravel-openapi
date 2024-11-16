<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Defs;

use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptor;

final readonly class Def
{
    private function __construct(
        private string $name,
        private Descriptor $descriptor,
    ) {
    }

    public static function create(string $name, Descriptor $descriptor): self
    {
        return new self($name, $descriptor);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): Descriptor
    {
        return $this->descriptor;
    }
}
