<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\String;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\String\FormatAnnotation\Format\StringFormat;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\String\Validations\MaxLength;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\String\Validations\MinLength;
use MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\String\Validations\Pattern;
use MohammadAlavi\ObjectOrientedJSONSchema\Format;
use MohammadAlavi\ObjectOrientedJSONSchema\Type;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final class StringDescriptor extends ExtensibleObject implements Descriptor
{
    private Type $type;
    private Format|null $format = null;
    private MaxLength|null $maxLength = null;
    private MinLength|null $minLength = null;
    private Pattern|null $pattern = null;

    public function format(StringFormat $format): self
    {
        $clone = clone $this;

        $clone->format = Format::create($format);

        return $clone;
    }

    public static function create(): self
    {
        $instance = new self();
        $instance->type = Type::string();

        return $instance;
    }

    /** A string is valid if its length is less than, or equal to this value */
    public function maxLength(int $value): self
    {
        $clone = clone $this;

         $clone->maxLength = MaxLength::create($value);

        return $clone;
    }

    /** A string is valid if its length is greater than, or equal to this value */
    public function minLength(int $value): self
    {
        $clone = clone $this;

        $clone->minLength = MinLength::create($value);

        return $clone;
    }

    /** A string is valid if it matches the given regular expression */
    public function pattern(string $value): self
    {
        $clone = clone $this;

        $clone->pattern = Pattern::create($value);

        return $clone;
    }

    protected function toArray(): array
    {
        $assertions = [];
        if ($this->format) {
            $assertions[$this->format::keyword()] = $this->format->value();
        }
        if ($this->maxLength) {
            $assertions[$this->maxLength::keyword()] = $this->maxLength->value();
        }
        if ($this->minLength) {
            $assertions[$this->minLength::keyword()] = $this->minLength->value();
        }
        if ($this->pattern) {
            $assertions[$this->pattern::keyword()] = $this->pattern->value();
        }

        return Arr::filter([
            $this->type::keyword() => $this->type->value(),
            ...$assertions,
        ]);
    }
}
