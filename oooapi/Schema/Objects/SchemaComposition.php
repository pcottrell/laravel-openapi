<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableSchemaFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\SchemaContract;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\SimpleCreator;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

// TODO: I believe SchemaComposition are not Schemas and should not extend SchemaContract
// They combine schemas together tho.
// So they hold a list of schemas.
// https://json-schema.org/understanding-json-schema/reference/object
// https://json-schema.org/understanding-json-schema/reference/combining
// I also believe we shouldn't be allowed to be added to Schema "properties" and "items" as they are not schemas.
abstract class SchemaComposition extends ExtensibleObject implements SchemaContract, SimpleCreator
{
    /** @var SchemaContract|ReusableSchemaFactory[]|null */
    protected array|null $schemas = null;

    public function schemas(SchemaContract|ReusableSchemaFactory ...$schema): static
    {
        $clone = clone $this;

        $clone->schemas = [] !== $schema ? $schema : null;

        return $clone;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            $this->compositionType() => $this->schemas,
        ]);
    }

    abstract protected function compositionType(): string;
}
