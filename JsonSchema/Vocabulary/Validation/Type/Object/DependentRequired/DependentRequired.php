<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Vocabulary\Validation\Type\Object\DependentRequired;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;

final readonly class DependentRequired implements SchemaProperty, Validation
{
    /** @param Dependency[] $dependencies */
    private function __construct(
        private array $dependencies,
    ) {
    }

    public static function create(Dependency ...$dependency): self
    {
        return new self($dependency);
    }

    public static function keyword(): string
    {
        return 'dependentRequired';
    }

    public function value(): array
    {
        $dependencies = [];
        foreach ($this->dependencies as $dependency) {
            $dependencies[$dependency->property()] = $dependency->dependencies();
        }

        return $dependencies;
    }
}
