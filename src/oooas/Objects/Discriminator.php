<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Discriminator extends BaseObject
{
    protected string|null $propertyName = null;
    protected array|null $mapping = null;

    public function propertyName(string|null $propertyName): static
    {
        $instance = clone $this;

        $instance->propertyName = $propertyName;

        return $instance;
    }

    /** @throws InvalidArgumentException */
    public function mapping(array $mapping): static
    {
        // Ensure the mappings are string => string.
        foreach ($mapping as $key => $value) {
            if (is_string($key) && is_string($value)) {
                continue;
            }

            throw new InvalidArgumentException('Each mapping must have a string key and a string value.');
        }

        $instance = clone $this;

        $instance->mapping = [] !== $mapping ? $mapping : null;

        return $instance;
    }

    protected function generate(): array
    {
        return Arr::filter([
            'propertyName' => $this->propertyName,
            'mapping' => $this->mapping,
        ]);
    }
}
