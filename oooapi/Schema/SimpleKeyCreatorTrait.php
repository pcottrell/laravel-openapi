<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema;

trait SimpleKeyCreatorTrait
{
    private readonly string $key;

    final public static function create(string $key): static
    {
        $static = new static();

        $static->key = $key;

        return $static;
    }

    final public function key(): string
    {
        return $this->key;
    }
}
