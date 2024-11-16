<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\Vocabularies;

use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\AllOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\AnyOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\OneOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptor;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generatable;

final class Applicator extends Generatable
{
    private AllOf|null $allOf = null;
    private AnyOf|null $anyOf = null;
    private OneOf|null $oneOf = null;

    private function __construct()
    {
    }

    public function allOf(bool|Descriptor ...$schema): self
    {
        $clone = clone $this;

        $clone->allOf = AllOf::create(...$schema);

        return $clone;
    }

    public static function create(): self
    {
        return new self();
    }

    public function anyOf(bool|Descriptor ...$schema): self
    {
        $clone = clone $this;

        $clone->anyOf = AnyOf::create(...$schema);

        return $clone;
    }

    public function oneOf(bool|Descriptor ...$schema): self
    {
        $clone = clone $this;

        $clone->oneOf = OneOf::create(...$schema);

        return $clone;
    }

    protected function toArray(): array
    {
        $applicators = [];
        if ($this->allOf) {
            $applicators[AllOf::name()] = $this->allOf->value();
        }
        if ($this->anyOf) {
            $applicators[AnyOf::name()] = $this->anyOf->value();
        }
        if ($this->oneOf) {
            $applicators[OneOf::name()] = $this->oneOf->value();
        }

        return Arr::filter($applicators);
    }
}
