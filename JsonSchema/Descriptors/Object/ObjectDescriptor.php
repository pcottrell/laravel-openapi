<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\TypeAware;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Applicators\Properties\Properties;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Applicators\Properties\Property;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations\DependentRequired\Dependency;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations\DependentRequired\DependentRequired;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations\MaxProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations\MinProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations\Required;
use MohammadAlavi\ObjectOrientedJSONSchema\HasTypeTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\Type;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final class ObjectDescriptor extends ExtensibleObject implements Descriptor, TypeAware
{
    use HasTypeTrait;

    // VALIDATIONS
    private DependentRequired|null $dependentRequired = null;
    private MaxProperties|null $maxProperties = null;
    private MinProperties|null $minProperties = null;
    private Required|null $required = null;

    // APPLICATORS
    private Properties|null $properties = null;

    /**
     * Specify a conditional dependency between object properties.
     * It ensures that if a certain property is present,
     * then another specified set of properties must also be present.
     * In short, if property A exists in the object, then properties B, C, and D must also be present.
     */
    public function dependentRequired(Dependency ...$dependency): self
    {
        $clone = clone $this;

        $clone->dependentRequired = DependentRequired::create(...$dependency);

        return $clone;
    }

    public static function create(): self
    {
        $instance = new self();
        $instance->type = Type::object();

        return $instance;
    }

    public function maxProperties(int $value): self
    {
        $clone = clone $this;

        $clone->maxProperties = MaxProperties::create($value);

        return $clone;
    }

    public function minProperties(int $value): self
    {
        $clone = clone $this;

        $clone->minProperties = MinProperties::create($value);

        return $clone;
    }

    public function required(string ...$property): self
    {
        $clone = clone $this;

        $clone->required = Required::create(...$property);

        return $clone;
    }

    public function properties(Property ...$property): self
    {
        $clone = clone $this;

        $clone->properties = Properties::create(...$property);

        return $clone;
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

        $applicators = [];
        if ($this->properties) {
            $applicators[$this->properties::keyword()] = $this->properties->value();
        }

        return Arr::filter([
            $this->type::keyword() => $this->type->value(),
            ...$assertions,
            ...$applicators,
        ]);
    }
}
