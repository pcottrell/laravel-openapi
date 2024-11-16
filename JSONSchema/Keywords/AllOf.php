<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Keyword;

final readonly class AllOf implements Keyword
{
    private function __construct(
        private array $schema,
    ) {
    }

    public static function create(BuilderInterface ...$schema): self
    {
        return new self($schema);
    }

    public static function name(): string
    {
        return 'allOf';
    }

    /** @return BuilderInterface[] */
    public function value(): array
    {
        return $this->schema;
    }
}
