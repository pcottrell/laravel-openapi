<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Validations\DependentRequired;

final readonly class Dependency
{
    private function __construct(
        private string $property,
        private array $dependencies,
    ) {
    }

    public static function create(string $property, string ...$dependency): self
    {
        return new self($property, ...$dependency);
    }

    public function property(): string
    {
        return $this->property;
    }

    public function dependencies(): array
    {
        return $this->dependencies;
    }
}
