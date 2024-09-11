<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

/**
 * @property Schema[]|null $schemas
 */
abstract class SchemaComposition extends BaseObject implements SchemaContract
{
    /**
     * @var Schema[]|null
     */
    protected $schemas;

    /**
     * @param Schema[] $schemas
     *
     * @return static
     */
    public function schemas(Schema ...$schemas): self
    {
        $instance = clone $this;

        $instance->schemas = $schemas ?: null;

        return $instance;
    }

    protected function generate(): array
    {
        return Arr::filter([
            $this->compositionType() => $this->schemas,
        ]);
    }

    abstract protected function compositionType(): string;
}
