<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Array;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\TypeAware;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Array\Applicators\Items;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Array\Validations\MaxContains;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Array\Validations\MaxItems;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Array\Validations\MinContains;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Array\Validations\MinItems;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Array\Validations\UniqueItems;
use MohammadAlavi\ObjectOrientedJSONSchema\HasTypeTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\Type;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final class ArrayDescriptor extends ExtensibleObject implements Descriptor, TypeAware
{
    use HasTypeTrait;

    private MaxItems|null $maxItems = null;
    private MinItems|null $minItems = null;
    private MaxContains|null $maxContains = null;
    private MinContains|null $minContains = null;
    private UniqueItems|null $uniqueItems = null;

    // APPLICATORS
    private Items|null $items = null;

    public function maxItems(int $value): self
    {
        $clone = clone $this;

        $clone->maxItems = MaxItems::create($value);

        return $clone;
    }

    public static function create(): self
    {
        $instance = new self();
        $instance->type = Type::array();

        return $instance;
    }

    public function minItems(int $value): self
    {
        $clone = clone $this;

        $clone->minItems = MinItems::create($value);

        return $clone;
    }

    public function maxContains(int $value): self
    {
        $clone = clone $this;

        $clone->maxContains = MaxContains::create($value);

        return $clone;
    }

    public function minContains(int $value): self
    {
        $clone = clone $this;

        $clone->minContains = MinContains::create($value);

        return $clone;
    }

    public function uniqueItems(bool $value = true): self
    {
        $clone = clone $this;

        $clone->uniqueItems = UniqueItems::create($value);

        return $clone;
    }

    public function items(Descriptor $schema): self
    {
        $clone = clone $this;

        $clone->items = Items::create($schema);

        return $clone;
    }

    protected function toArray(): array
    {
        $assertions = [];
        if ($this->maxItems) {
            $assertions[$this->maxItems::keyword()] = $this->maxItems->value();
        }
        if ($this->minItems) {
            $assertions[$this->minItems::keyword()] = $this->minItems->value();
        }
        if ($this->maxContains) {
            $assertions[$this->maxContains::keyword()] = $this->maxContains->value();
        }
        if ($this->minContains) {
            $assertions[$this->minContains::keyword()] = $this->minContains->value();
        }
        if ($this->uniqueItems) {
            $assertions[$this->uniqueItems::keyword()] = $this->uniqueItems->value();
        }

        $applicators = [];
        if ($this->items) {
            $applicators[$this->items::keyword()] = $this->items->value();
        }

        return Arr::filter([
            $this->type::keyword() => $this->type->value(),
            ...$assertions,
            ...$applicators,
        ]);
    }
}
