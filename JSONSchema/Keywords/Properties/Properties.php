<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Properties;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Keyword;

final readonly class Properties implements Keyword
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

    public static function name(): string
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
