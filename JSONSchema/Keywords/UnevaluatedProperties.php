<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Keyword;

final readonly class UnevaluatedProperties implements Keyword
{
    private function __construct(
        private BuilderInterface $schema,
    ) {
    }

    public static function create(BuilderInterface $schema): self
    {
        return new self($schema);
    }

    public static function name(): string
    {
        return 'unevaluatedProperties';
    }

    public function value(): BuilderInterface
    {
        return $this->schema;
    }
}
