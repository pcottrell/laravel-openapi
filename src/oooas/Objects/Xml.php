<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Xml extends BaseObject
{
    protected string|null $name = null;
    protected string|null $namespace = null;
    protected string|null $prefix = null;
    protected bool|null $attribute = null;
    protected bool|null $wrapped = null;

    public function name(string|null $name): static
    {
        $instance = clone $this;

        $instance->name = $name;

        return $instance;
    }

    public function namespace(string|null $namespace): static
    {
        $instance = clone $this;

        $instance->namespace = $namespace;

        return $instance;
    }

    public function prefix(string|null $prefix): static
    {
        $instance = clone $this;

        $instance->prefix = $prefix;

        return $instance;
    }

    public function attribute(bool|null $attribute = true): static
    {
        $instance = clone $this;

        $instance->attribute = $attribute;

        return $instance;
    }

    public function wrapped(bool|null $wrapped = true): static
    {
        $instance = clone $this;

        $instance->wrapped = $wrapped;

        return $instance;
    }

    public function generate(): array
    {
        return Arr::filter([
            'name' => $this->name,
            'namespace' => $this->namespace,
            'prefix' => $this->prefix,
            'attribute' => $this->attribute,
            'wrapped' => $this->wrapped,
        ]);
    }
}
