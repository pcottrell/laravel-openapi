<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Keyword;

final readonly class AnyOf implements Keyword
{
    private function __construct(
        private array $schema,
    ) {
    }

    public static function create(Builder ...$builder): self
    {
        return new self($builder);
    }

    public static function name(): string
    {
        return 'anyOf';
    }

    /** @return Builder[] */
    public function value(): array
    {
        return $this->schema;
    }
}
