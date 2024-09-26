<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Not extends ExtensibleObject implements SchemaContract
{
    protected Schema|null $schema = null;

    public function schema(Schema|null $schema): static
    {
        $instance = clone $this;

        $instance->schema = $schema;

        return $instance;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'not' => $this->schema,
        ]);
    }
}
