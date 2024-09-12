<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Example extends BaseObject
{
    protected string|null $summary = null;
    protected string|null $description = null;
    protected mixed $value = null;
    protected string|null $externalValue = null;

    public function summary(string|null $summary): static
    {
        $instance = clone $this;

        $instance->summary = $summary;

        return $instance;
    }

    public function description(string|null $description): static
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    public function value(mixed $value): static
    {
        $instance = clone $this;

        $instance->value = $value;

        return $instance;
    }

    public function externalValue(string|null $externalValue): static
    {
        $instance = clone $this;

        $instance->externalValue = $externalValue;

        return $instance;
    }

    protected function generate(): array
    {
        return Arr::filter([
            'summary' => $this->summary,
            'description' => $this->description,
            'value' => $this->value,
            'externalValue' => $this->externalValue,
        ]);
    }
}
