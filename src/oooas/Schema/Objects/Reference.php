<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\NonExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

final class Reference extends NonExtensibleObject
{
    private function __construct(
        public readonly string $ref,
        public readonly string|null $summary,
        public readonly string|null $description,
    ) {
    }

    public static function create(string $ref, string|null $summary = null, string|null $description = null): self
    {
        return new self($ref, $summary, $description);
    }

    protected function toArray(): array
    {
        return Arr::filter([
            '$ref' => $this->ref,
            'summary' => $this->summary,
            'description' => $this->description,
        ]);
    }
}
