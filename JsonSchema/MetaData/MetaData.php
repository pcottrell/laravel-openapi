<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\MetaData;

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generatable;

final class MetaData extends Generatable
{
    private Title|null $title = null;
    private Description|null $description = null;
    private DefaultValue|null $defaultValue = null;
    private Deprecated|null $deprecated = null;
    private Examples|null $examples = null;
    private IsReadOnly|null $readOnly = null;
    private IsWriteOnly|null $writeOnly = null;

    private function __construct()
    {
    }

    public function title(string $value): self
    {
        $clone = clone $this;

        $clone->title = Title::create($value);

        return $clone;
    }

    public static function create(): self
    {
        return new self();
    }

    public function description(string $value): self
    {
        $clone = clone $this;

        $clone->description = Description::create($value);

        return $clone;
    }

    public function default(mixed $value): self
    {
        $clone = clone $this;

        $clone->defaultValue = DefaultValue::create($value);

        return $clone;
    }

    public function deprecated(bool $value): self
    {
        $clone = clone $this;

        $clone->deprecated = Deprecated::create($value);

        return $clone;
    }

    public function examples(mixed ...$value): self
    {
        $clone = clone $this;

        $clone->examples = Examples::create(...$value);

        return $clone;
    }

    public function readOnly(bool $value): self
    {
        $clone = clone $this;

        $clone->readOnly = IsReadOnly::create($value);

        return $clone;
    }

    public function writeOnly(bool $value): self
    {
        $clone = clone $this;

        $clone->writeOnly = IsWriteOnly::create($value);

        return $clone;
    }

    protected function toArray(): array
    {
        $metaData = [];
        if ($this->title) {
            $metaData[$this->title::keyword()] = $this->title->value();
        }
        if ($this->description) {
            $metaData[$this->description::keyword()] = $this->description->value();
        }
        if ($this->defaultValue) {
            $metaData[$this->defaultValue::keyword()] = $this->defaultValue->value();
        }
        if ($this->deprecated) {
            $metaData[$this->deprecated::keyword()] = $this->deprecated->value();
        }
        if ($this->examples) {
            $metaData[$this->examples::keyword()] = $this->examples->value();
        }
        if ($this->readOnly) {
            $metaData[$this->readOnly::keyword()] = $this->readOnly->value();
        }
        if ($this->writeOnly) {
            $metaData[$this->writeOnly::keyword()] = $this->writeOnly->value();
        }

        return Arr::filter($metaData);
    }
}
