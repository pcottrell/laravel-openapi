<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\NonExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final class Reference extends NonExtensibleObject
{
    // TODO: description and summary by default SHOULD override that of the referenced component.
    // This is not possible with the current implementation.
    // This is specially importance for the Response object.
    private function __construct(
        private readonly string $ref,
        private readonly string|null $summary,
        private readonly string|null $description,
    ) {
    }

    public static function create(string $ref, string|null $summary = null, string|null $description = null): self
    {
        return new self($ref, $summary, $description);
    }

    public function ref(): string
    {
        return $this->ref;
    }

    public function summary(): string|null
    {
        return $this->summary;
    }

    public function description(): string|null
    {
        return $this->description;
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
