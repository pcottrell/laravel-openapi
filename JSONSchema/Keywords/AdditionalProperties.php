<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Keyword;

final readonly class AdditionalProperties implements Keyword
{
    private function __construct(
        private BuilderInterface|bool $schema,
    ) {
    }

    public static function create(BuilderInterface|bool $schema): self
    {
        return new self($schema);
    }

    public static function name(): string
    {
        return 'additionalProperties';
    }

    public function value(): BuilderInterface|bool
    {
        return $this->schema;
    }
}
