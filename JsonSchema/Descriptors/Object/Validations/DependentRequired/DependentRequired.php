<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations\DependentRequired;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;

final readonly class DependentRequired implements Validation
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
