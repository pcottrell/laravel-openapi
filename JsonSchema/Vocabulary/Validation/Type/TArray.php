<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type;

use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\Array\MaxContains;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\Array\MaxItems;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\Array\MinContains;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\Array\MinItems;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\Array\UniqueItems;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\JsonSchema;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final class TArray extends ExtensibleObject implements JsonSchema
{
    private Type $type;
    private MaxItems|null $maxItems = null;
    private MinItems|null $minItems = null;
    private MaxContains|null $maxContains = null;
    private MinContains|null $minContains = null;
    private UniqueItems|null $uniqueItems = null;

    public static function create(): self
    {
        $instance = new self();
        $instance->type = Type::array();

        return $instance;
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

        return Arr::filter([
            $this->type::keyword() => $this->type->value(),
            ...$assertions,
        ]);
    }
}
