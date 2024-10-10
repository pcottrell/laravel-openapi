<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema;

trait SimpleKeyCreatorTrait
{
    private readonly string $key;

    final public static function create(string $key): static
    {
        $instance = new static();

        $instance->key = $key;

        return $instance;
    }

    final public function key(): string
    {
        return $this->key;
    }
}
