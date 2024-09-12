<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

/**
 * @property string[]|null $enum
 * @property string|null $default
 * @property string|null $description
 */
class ServerVariable extends BaseObject
{
    /** @var string[]|null */
    protected array|null $enum = null;

    protected string|null $default = null;
    protected string|null $description = null;

    /**
     * @param string[] $enum
     *
     * @return static
     */
    public function enum(string ...$enum): self
    {
        $instance = clone $this;

        $instance->enum = [] !== $enum ? $enum : null;

        return $instance;
    }

    /** @return static */
    public function default(string|null $default): self
    {
        $instance = clone $this;

        $instance->default = $default;

        return $instance;
    }

    /** @return static */
    public function description(string|null $description): self
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    protected function generate(): array
    {
        return Arr::filter([
            'enum' => $this->enum,
            'default' => $this->default,
            'description' => $this->description,
        ]);
    }
}
