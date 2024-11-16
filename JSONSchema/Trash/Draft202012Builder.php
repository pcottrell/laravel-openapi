<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash;

use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\BuilderMethods;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Constraints;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Draft202012BuilderInterfaceInterface;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generatable;

class Draft202012Builder extends Generatable implements Draft202012BuilderInterfaceInterface
{
//    use BuilderMethods;
    use Constraints;

    public static function create(): static
    {
        return (new self())
            ->schema('http://json-schema.org/draft-2020-12/schema');
    }

    protected function toArray(): array
    {
        $keywords = [];
        if ($this->ref) {
            $keywords[$this->ref::name()] = $this->ref->value();
        }
        if ($this->defs) {
            $keywords[$this->defs::name()] = $this->defs->value();
        }
        if ($this->schema) {
            $keywords[$this->schema::name()] = $this->schema->value();
        }
        if ($this->id) {
            $keywords[$this->id::name()] = $this->id->value();
        }
        if ($this->comment) {
            $keywords[$this->comment::name()] = $this->comment->value();
        }
        if ($this->anchor) {
            $keywords[$this->anchor::name()] = $this->anchor->value();
        }
        if ($this->dynamicAnchor) {
            $keywords[$this->dynamicAnchor::name()] = $this->dynamicAnchor->value();
        }
        if ($this->dynamicRef) {
            $keywords[$this->dynamicRef::name()] = $this->dynamicRef->value();
        }
        if ($this->vocabulary) {
            $keywords[$this->vocabulary::name()] = $this->vocabulary->value();
        }
        if ($this->unevaluatedItems) {
            $keywords[$this->unevaluatedItems::name()] = $this->unevaluatedItems->value();
        }
        if ($this->unevaluatedProperties) {
            $keywords[$this->unevaluatedProperties::name()] = $this->unevaluatedProperties->value();
        }
        if ($this->format) {
            $keywords[$this->format::name()] = $this->format->value();
        }
        if ($this->maxLength) {
            $keywords[$this->maxLength::name()] = $this->maxLength->value();
        }
        if ($this->minLength) {
            $keywords[$this->minLength::name()] = $this->minLength->value();
        }
        if ($this->pattern) {
            $keywords[$this->pattern::name()] = $this->pattern->value();
        }
        if ($this->type) {
            $keywords[$this->type::name()] = $this->type->value();
        }
        if ($this->exclusiveMaximum) {
            $keywords[$this->exclusiveMaximum::name()] = $this->exclusiveMaximum->value();
        }
        if ($this->exclusiveMinimum) {
            $keywords[$this->exclusiveMinimum::name()] = $this->exclusiveMinimum->value();
        }
        if ($this->maximum) {
            $keywords[$this->maximum::name()] = $this->maximum->value();
        }
        if ($this->minimum) {
            $keywords[$this->minimum::name()] = $this->minimum->value();
        }
        if ($this->multipleOf) {
            $keywords[$this->multipleOf::name()] = $this->multipleOf->value();
        }

        return Arr::filter($keywords);
    }
}
