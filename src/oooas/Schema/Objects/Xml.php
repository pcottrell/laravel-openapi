<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface\SimpleCreator;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\SimpleCreatorTrait;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Xml extends ExtensibleObject implements SimpleCreator
{
    use SimpleCreatorTrait;

    protected string|null $name = null;
    protected string|null $namespace = null;
    protected string|null $prefix = null;
    protected bool|null $attribute = null;
    protected bool|null $wrapped = null;

    public function name(string|null $name): static
    {
        $clone = clone $this;

        $clone->name = $name;

        return $clone;
    }

    public function namespace(string|null $namespace): static
    {
        $clone = clone $this;

        $clone->namespace = $namespace;

        return $clone;
    }

    public function prefix(string|null $prefix): static
    {
        $clone = clone $this;

        $clone->prefix = $prefix;

        return $clone;
    }

    public function attribute(bool|null $attribute = true): static
    {
        $clone = clone $this;

        $clone->attribute = $attribute;

        return $clone;
    }

    public function wrapped(bool|null $wrapped = true): static
    {
        $clone = clone $this;

        $clone->wrapped = $wrapped;

        return $clone;
    }

    protected function toArray(): array
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
