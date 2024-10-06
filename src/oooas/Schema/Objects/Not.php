<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface\SchemaContract;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Not extends ExtensibleObject implements SchemaContract
{
    protected Schema|null $schema = null;

    public function schema(Schema|null $schema): static
    {
        $clone = clone $this;

        $clone->schema = $schema;

        return $clone;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'not' => $this->schema,
        ]);
    }
}
