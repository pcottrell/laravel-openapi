<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema;

use MohammadAlavi\ObjectOrientedJSONSchema\Applicator\AllOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Applicator\AnyOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Applicator\OneOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
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
            $applicators[AllOf::keyword()] = $this->allOf->value();
        }
        if ($this->anyOf) {
            $applicators[AnyOf::keyword()] = $this->anyOf->value();
        }
        if ($this->oneOf) {
            $applicators[OneOf::keyword()] = $this->oneOf->value();
        }

        return Arr::filter($applicators);
    }
}
