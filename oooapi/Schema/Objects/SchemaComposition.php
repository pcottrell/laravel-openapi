<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableSchemaFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\JsonSchema;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\SimpleKeyCreator;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\SimpleKeyCreatorTrait;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generator;

// TODO: I believe SchemaComposition are not Schemas and should not extend SchemaContract
// They combine schemas together tho.
// So they hold a list of schemas.
// https://json-schema.org/understanding-json-schema/reference/object
// https://json-schema.org/understanding-json-schema/reference/combining
// I also believe we shouldn't be allowed to be added to Schema "properties" and "items" as they are not schemas.
abstract class SchemaComposition implements JsonSchema, SimpleKeyCreator, \JsonSerializable
{
    use Generator;
    use SimpleKeyCreatorTrait;

    /** @var JsonSchema|ReusableSchemaFactory[]|null */
    protected array|null $schemas = null;

    public function schemas(JsonSchema|ReusableSchemaFactory ...$schema): static
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

    abstract public function compositionType(): string;
}
