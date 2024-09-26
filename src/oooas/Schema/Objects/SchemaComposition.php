<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

abstract class SchemaComposition extends ExtensibleObject implements SchemaContract
{
    /** @var Schema[]|null */
    protected array|null $schemas = null;

    /** @param Schema[] $schema */
    public function schemas(Schema ...$schema): static
    {
        $instance = clone $this;

        $instance->schemas = [] !== $schema ? $schema : null;

        return $instance;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            $this->compositionType() => $this->schemas,
        ]);
    }

    abstract protected function compositionType(): string;
}
