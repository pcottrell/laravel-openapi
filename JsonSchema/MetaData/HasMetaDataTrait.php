<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\MetaData;

use MohammadAlavi\ObjectOrientedJSONSchema\MetaData;

trait HasMetaDataTrait
{
    private MetaData|null $metaData = null;

    public function title(string $value): self
    {
        $clone = clone $this;

        $clone->metaData = $this->metaData->title($value);

        return $clone;
    }

    public function description(string $value): self
    {
        $clone = clone $this;

        $clone->metaData = $this->metaData->description($value);

        return $clone;
    }

    public function default(mixed $value): self
    {
        $clone = clone $this;

        $clone->metaData = $this->metaData->default($value);

        return $clone;
    }

    public function deprecated(bool $value = true): self
    {
        $clone = clone $this;

        $clone->metaData = $this->metaData->deprecated($value);

        return $clone;
    }

    public function examples(mixed ...$value): self
    {
        $clone = clone $this;

        $clone->metaData = $this->metaData->examples(...$value);

        return $clone;
    }

    public function readOnly(bool $value = true): self
    {
        $clone = clone $this;

        $clone->metaData = $this->metaData->readOnly($value);

        return $clone;
    }

    public function writeOnly(bool $value = true): self
    {
        $clone = clone $this;

        $clone->metaData = $this->metaData->writeOnly($value);

        return $clone;
    }
}
