<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object;

use MohammadAlavi\ObjectOrientedJSONSchema\Applicator;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\TypeAware;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Applicators\AdditionalProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Applicators\Properties\Properties;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Applicators\Properties\Property;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations\DependentRequired\Dependency;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations\DependentRequired\DependentRequired;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations\MaxProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations\MinProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations\Required;
use MohammadAlavi\ObjectOrientedJSONSchema\GeneralTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\HasTypeTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\MetaData;
use MohammadAlavi\ObjectOrientedJSONSchema\Type;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final class ObjectDescriptor extends ExtensibleObject implements Descriptor, TypeAware
{
    use HasTypeTrait;
    use GeneralTrait;

    // VALIDATIONS
    private DependentRequired|null $dependentRequired = null;
    private MaxProperties|null $maxProperties = null;
    private MinProperties|null $minProperties = null;
    private Required|null $required = null;

    // APPLICATORS
    private Properties|null $properties = null;
    private AdditionalProperties|bool|null $additionalProperties = null;

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
        $instance->metaData = MetaData::create();
        $instance->applicator = Applicator::create();

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

    /**
     * This method is used
     * to control the handling of properties whose names are not listed by the "properties" method
     * or match any of the regular expressions set by the "patternProperties" method.
     * By default, any additional properties are allowed.
     *
     * @see https://www.learnjsonschema.com/2020-12/applicator/additionalproperties/
     */
    public function additionalProperties(Descriptor|bool $value = true): self
    {
        $clone = clone $this;

        $clone->additionalProperties = AdditionalProperties::create($value);

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
        if ($this->additionalProperties) {
            $applicators[$this->additionalProperties::keyword()] = $this->additionalProperties->value();
        }

        return Arr::filter([
            $this->type::keyword() => $this->type->value(),
            ...$assertions,
            ...$applicators,
            ...$this->metaData->jsonSerialize(),
            ...$this->applicator->jsonSerialize(),
        ]);
    }
}
