<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface\SimpleCreator;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\SimpleCreatorTrait;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Tag extends ExtensibleObject implements \Stringable, SimpleCreator
{
    use SimpleCreatorTrait;

    protected string|null $name = null;
    protected string|null $description = null;
    protected ExternalDocs|null $externalDocs = null;

    public function name(string|null $name): static
    {
        $clone = clone $this;

        $clone->name = $name;

        return $clone;
    }

    public function description(string|null $description): static
    {
        $clone = clone $this;

        $clone->description = $description;

        return $clone;
    }

    public function externalDocs(ExternalDocs|null $externalDocs): static
    {
        $clone = clone $this;

        $clone->externalDocs = $externalDocs;

        return $clone;
    }

    public function __toString(): string
    {
        return (string) $this->name;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'name' => $this->name,
            'description' => $this->description,
            'externalDocs' => $this->externalDocs,
        ]);
    }
}
