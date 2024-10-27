<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Applicator;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Applicator;

final readonly class OneOf implements Applicator
{
    private function __construct(
        private array $schema,
    ) {
    }

    public static function create(bool|Descriptor ...$schema): self
    {
        return new self($schema);
    }

    public static function keyword(): string
    {
        return 'oneOf';
    }

    /** @return (bool|Descriptor)[] */
    public function value(): array
    {
        return $this->schema;
    }
}
