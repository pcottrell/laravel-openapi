<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptors;

use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Vocabularies\Applicator;
use MohammadAlavi\ObjectOrientedJSONSchema\Review\TypeAware;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Review\HasTypeTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\ExclusiveMaximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\ExclusiveMinimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Maximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Minimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\MultipleOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Type;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Vocabularies\MetaData;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

abstract class NumeralDescriptor extends ExtensibleObject implements Descriptor, TypeAware
{
    use HasTypeTrait;

    private ExclusiveMaximum|null $exclusiveMaximum = null;
    private ExclusiveMinimum|null $exclusiveMinimum = null;
    private Maximum|null $maximum = null;
    private Minimum|null $minimum = null;
    private MultipleOf|null $multipleOf = null;

    /**
     * Integer is a data type specific to OAS and is not included in the JSON Schema specification.
     */
    final protected static function integer(): static
    {
        $instance = new static();
        $instance->type = Type::integer();
        $instance->metaData = MetaData::create();
        $instance->applicator = Applicator::create();

        return $instance;
    }

    final protected static function number(): static
    {
        $instance = new static();
        $instance->type = Type::number();

        return $instance;
    }

    /** A number is valid if it is strictly less than (not equal to) the provided maximum value. */
    final public function exclusiveMaximum(float $value): self
    {
        $clone = clone $this;

        $clone->exclusiveMaximum = ExclusiveMaximum::create($value);

        return $clone;
    }

    /** A number is valid if it is strictly greater than (not equal to) the provided minimum value. */
    final public function exclusiveMinimum(float $value): self
    {
        $clone = clone $this;

        $clone->exclusiveMinimum = ExclusiveMinimum::create($value);

        return $clone;
    }

    /** A number is valid if it is less than, or equal to this value */
    final public function maximum(float $value): self
    {
        $clone = clone $this;

        $clone->maximum = Maximum::create($value);

        return $clone;
    }

    /** A number is valid if it is greater than, or equal to this value */
    final public function minimum(float $value): self
    {
        $clone = clone $this;

        $clone->minimum = Minimum::create($value);

        return $clone;
    }

    /** A number is valid if it is divisible by this value */
    final public function multipleOf(float $value): self
    {
        $clone = clone $this;

        $clone->multipleOf = MultipleOf::create($value);

        return $clone;
    }

    final protected function toArray(): array
    {
        $assertions = [];
        if ($this->format) {
            $assertions[$this->format::keyword()] = $this->format->value();
        }
        if ($this->exclusiveMaximum) {
            $assertions[$this->exclusiveMaximum::name()] = $this->exclusiveMaximum->value();
        }
        if ($this->exclusiveMinimum) {
            $assertions[$this->exclusiveMinimum::name()] = $this->exclusiveMinimum->value();
        }
        if ($this->maximum) {
            $assertions[$this->maximum::name()] = $this->maximum->value();
        }
        if ($this->minimum) {
            $assertions[$this->minimum::name()] = $this->minimum->value();
        }
        if ($this->multipleOf) {
            $assertions[$this->multipleOf::name()] = $this->multipleOf->value();
        }

        return Arr::filter([
            $this->type::name() => $this->type->value(),
            ...$assertions,
            ...$this->metaData->jsonSerialize(),
            ...$this->applicator->jsonSerialize(),
        ]);
    }
}
