<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

abstract class SchemaComposition extends BaseObject implements SchemaContract
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

    public function generate(): array
    {
        return Arr::filter([
            $this->compositionType() => $this->schemas,
        ]);
    }

    abstract protected function compositionType(): string;
}
