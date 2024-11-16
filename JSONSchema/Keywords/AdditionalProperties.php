<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Builder\Builder;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Keyword;

final readonly class AdditionalProperties implements Keyword
{
    private function __construct(
        private Builder|bool $schema,
    ) {
    }

    public static function create(Builder|bool $schema): self
    {
        return new self($schema);
    }

    public static function name(): string
    {
        return 'additionalProperties';
    }

    public function value(): Builder|bool
    {
        return $this->schema;
    }
}
