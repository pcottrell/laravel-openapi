<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Defs;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;

final readonly class Def
{
    private function __construct(
        private string $name,
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

    public function value(): Builder
    {
        return $this->builder;
    }
}
