<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class ServerVariable extends ExtensibleObject
{
    /** @var string[]|null */
    protected array|null $enum = null;

    protected string|null $default = null;
    protected string|null $description = null;

    public function enum(string ...$enum): static
    {
        $instance = clone $this;

        $instance->enum = [] !== $enum ? $enum : null;

        return $instance;
    }

    public function default(string|null $default): static
    {
        $instance = clone $this;

        $instance->default = $default;

        return $instance;
    }

    public function description(string|null $description): static
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'enum' => $this->enum,
            'default' => $this->default,
            'description' => $this->description,
        ]);
    }
}
