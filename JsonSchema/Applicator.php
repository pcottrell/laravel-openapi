<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema;

use MohammadAlavi\ObjectOrientedJSONSchema\Applicator\AllOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Applicator\AnyOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Applicator\OneOf;
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

    public static function create(): self
    {
        return new self();
    }

    public function allOf(AllOf $allOf): self
    {
        $clone = clone $this;

        $clone->allOf = $allOf;

        return $clone;
    }

    public function anyOf(AnyOf $anyOf): self
    {
        $clone = clone $this;

        $clone->anyOf = $anyOf;

        return $clone;
    }

    public function oneOf(OneOf $oneOf): self
    {
        $clone = clone $this;

        $clone->oneOf = $oneOf;

        return $clone;
    }

    protected function toArray(): array
    {
        $applicators = [];
        if ($this->allOf) {
            $applicators[$this->allOf::keyword()] = $this->allOf->value();
        }
        if ($this->anyOf) {
            $applicators[$this->anyOf::keyword()] = $this->anyOf->value();
        }
        if ($this->oneOf) {
            $applicators[$this->oneOf::keyword()] = $this->oneOf->value();
        }

        return Arr::filter($applicators);
    }
}
