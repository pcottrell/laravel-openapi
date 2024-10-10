<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface\SchemaContract;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\SimpleCreatorTrait;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

// TODO: I think it doesnt make sense to be able to create a Not object without a schema
// So I think we should remove the null from the schema property and also remove the schema method
// And just add a constructor that accepts a schema object
// https://json-schema.org/understanding-json-schema/reference/combining
// Another Note:
// Not should also accept an anonymous schema object and the Schema doesn't need a key
class Not extends ExtensibleObject implements SchemaContract
{
    use SimpleCreatorTrait;

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
