<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Descriptors\Object\Applicators\Properties;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\SchemaProperty;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Applicator;

final readonly class Properties implements SchemaProperty, Applicator
{
    /** @param Property[] $properties */
    private function __construct(
        private array $properties,
    ) {
    }

    public static function create(Property ...$property): self
    {
        return new self($property);
    }

    public static function keyword(): string
    {
        return 'properties';
    }

    public function value(): array
    {
        $properties = [];
        foreach ($this->properties as $property) {
            $properties[$property->name()] = $property->schema();
        }

        return $properties;
    }
}
