<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface\SimpleKeyCreator;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\SimpleKeyCreatorTrait;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Example extends ExtensibleObject implements SimpleKeyCreator
{
    use SimpleKeyCreatorTrait;

    protected string|null $summary = null;
    protected string|null $description = null;
    protected mixed $value = null;
    protected string|null $externalValue = null;

    public function summary(string|null $summary): static
    {
        $clone = clone $this;

        $clone->summary = $summary;

        return $clone;
    }

    public function description(string|null $description): static
    {
        $clone = clone $this;

        $clone->description = $description;

        return $clone;
    }

    public function value(mixed $value): static
    {
        $clone = clone $this;

        $clone->value = $value;

        return $clone;
    }

    public function externalValue(string|null $externalValue): static
    {
        $clone = clone $this;

        $clone->externalValue = $externalValue;

        return $clone;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'summary' => $this->summary,
            'description' => $this->description,
            'value' => $this->value,
            'externalValue' => $this->externalValue,
        ]);
    }

    public function key(): string
    {
        // TODO: Implement key() method.
    }
}
