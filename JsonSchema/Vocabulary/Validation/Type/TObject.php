<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type;

use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\Object\DependentRequired\DependentRequired;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\Object\MaxProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\Object\MinProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\Object\Required;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\JsonSchema;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final class TObject extends ExtensibleObject implements JsonSchema
{
    private Type $type;
    private DependentRequired|null $dependentRequired = null;
    private MaxProperties|null $maxProperties = null;
    private MinProperties|null $minProperties = null;
    private Required|null $required = null;

    public static function create(): self
    {
        $instance = new self();
        $instance->type = Type::object();

        return $instance;
    }

    protected function toArray(): array
    {
        $assertions = [];
        if ($this->dependentRequired) {
            $assertions[$this->dependentRequired::keyword()] = $this->dependentRequired->value();
        }
        if ($this->maxProperties) {
            $assertions[$this->maxProperties::keyword()] = $this->maxProperties->value();
        }
        if ($this->minProperties) {
            $assertions[$this->minProperties::keyword()] = $this->minProperties->value();
        }
        if ($this->required) {
            $assertions[$this->required::keyword()] = $this->required->value();
        }

        return Arr::filter([
            $this->type::keyword() => $this->type->value(),
            ...$assertions,
        ]);
    }
}
