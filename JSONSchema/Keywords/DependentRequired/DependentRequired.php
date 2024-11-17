<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords\DependentRequired;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Keyword;

final readonly class DependentRequired implements Keyword
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

    public static function name(): string
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
