<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Properties;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;

final readonly class Property
{
    private function __construct(
        private string  $name,
        private Builder $builder,
    ) {
    }

    public static function create(string $name, Builder $builder): self
    {
        return new self($name, $builder);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function schema(): Builder
    {
        return $this->builder;
    }
}
