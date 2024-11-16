<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema;

use MohammadAlavi\ObjectOrientedJSONSchema\Formats\DefinedFormat;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\DependentRequired\Dependency;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Properties\Property;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Defs\Def;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Type;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Vocabulary\Vocab;

abstract class BuilderDecorator implements BuilderInterface
{
    private Builder $builder;

    public function __construct()
    {
        $this->builder = new Builder();
    }

    public function schema(string $uri): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->schema($uri);

        return $clone;
    }

    public function ref(string $uri): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->ref($uri);

        return $clone;
    }

    public function defs(Def ...$def): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->defs(...$def);

        return $clone;
    }

    public function id(string $uri): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->id($uri);

        return $clone;
    }

    public function comment(string $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->comment($value);

        return $clone;
    }

    public function anchor(string $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->anchor($value);

        return $clone;
    }

    public function dynamicAnchor(string $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->dynamicAnchor($value);

        return $clone;
    }

    public function dynamicRef(string $uri): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->dynamicRef($uri);

        return $clone;
    }

    public function vocabulary(Vocab ...$vocab): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->vocabulary(...$vocab);

        return $clone;
    }

    public function unevaluatedItems(BuilderInterface $schema): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->unevaluatedItems($schema);

        return $clone;
    }

    public function unevaluatedProperties(BuilderInterface $schema): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->unevaluatedProperties($schema);

        return $clone;
    }

    public function format(DefinedFormat $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->format($value);

        return $clone;
    }

    public function maxLength(int $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->maxLength($value);

        return $clone;
    }

    public function minLength(int $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->minLength($value);

        return $clone;
    }

    public function pattern(string $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->pattern($value);

        return $clone;
    }

    public function type(Type|string ...$type): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->type(...$type);

        return $clone;
    }

    public function exclusiveMaximum(float $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->exclusiveMaximum($value);

        return $clone;
    }

    public function exclusiveMinimum(float $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->exclusiveMinimum($value);

        return $clone;
    }

    public function maximum(float $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->maximum($value);

        return $clone;
    }

    public function minimum(float $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->minimum($value);

        return $clone;
    }

    public function multipleOf(float $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->multipleOf($value);

        return $clone;
    }

    public function maxContains(int $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->maxContains($value);

        return $clone;
    }

    public function maxItems(int $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->maxItems($value);

        return $clone;
    }

    public function minContains(int $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->minContains($value);

        return $clone;
    }

    public function minItems(int $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->minItems($value);

        return $clone;
    }

    public function uniqueItems(bool $value = true): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->uniqueItems($value);

        return $clone;
    }

    public function items(BuilderInterface $schema): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->items($schema);

        return $clone;
    }

    public function allOf(BuilderInterface ...$schema): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->allOf(...$schema);

        return $clone;
    }

    public function anyOf(BuilderInterface ...$schema): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->anyOf(...$schema);

        return $clone;
    }

    public function oneOf(BuilderInterface ...$schema): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->oneOf(...$schema);

        return $clone;
    }

    public function additionalProperties(BuilderInterface|bool $schema): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->additionalProperties($schema);

        return $clone;
    }

    public function properties(Property ...$schema): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->properties(...$schema);

        return $clone;
    }

    public function dependentRequired(Dependency ...$dependency): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->dependentRequired(...$dependency);

        return $clone;
    }

    public function maxProperties(int $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->maxProperties($value);

        return $clone;
    }

    public function minProperties(int $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->minProperties($value);

        return $clone;
    }

    public function required(string ...$property): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->required(...$property);

        return $clone;
    }

    public function default(mixed $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->default($value);

        return $clone;
    }

    public function deprecated(bool $value = true): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->deprecated($value);

        return $clone;
    }

    public function description(string $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->description($value);

        return $clone;
    }

    public function examples(...$example): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->examples(...$example);

        return $clone;
    }

    public function readOnly(bool $value = true): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->readOnly($value);

        return $clone;
    }

    public function writeOnly(bool $value = true): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->writeOnly($value);

        return $clone;
    }

    public function title(string $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->title($value);

        return $clone;
    }

    public function const(mixed $value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->const($value);

        return $clone;
    }

    public function enum(...$value): static
    {
        $clone = clone $this;

        $clone->builder = $this->builder->enum(...$value);

        return $clone;
    }

    public function jsonSerialize(): array
    {
        return $this->builder->jsonSerialize();
    }
}
