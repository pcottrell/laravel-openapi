<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\TypeAware;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\Validations\ExclusiveMaximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\Validations\ExclusiveMinimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\Validations\Maximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\Validations\Minimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Numeral\Validations\MultipleOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Format;
use MohammadAlavi\ObjectOrientedJSONSchema\HasTypeTrait;
use MohammadAlavi\ObjectOrientedJSONSchema\Type;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

abstract class NumeralDescriptor extends ExtensibleObject implements Descriptor, TypeAware
{
    use HasTypeTrait;

    protected Format|null $format = null;
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
            $assertions[$this->exclusiveMaximum::keyword()] = $this->exclusiveMaximum->value();
        }
        if ($this->exclusiveMinimum) {
            $assertions[$this->exclusiveMinimum::keyword()] = $this->exclusiveMinimum->value();
        }
        if ($this->maximum) {
            $assertions[$this->maximum::keyword()] = $this->maximum->value();
        }
        if ($this->minimum) {
            $assertions[$this->minimum::keyword()] = $this->minimum->value();
        }
        if ($this->multipleOf) {
            $assertions[$this->multipleOf::keyword()] = $this->multipleOf->value();
        }

        return Arr::filter([
            $this->type::keyword() => $this->type->value(),
            ...$assertions,
        ]);
    }
}
