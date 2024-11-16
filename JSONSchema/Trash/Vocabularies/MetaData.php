<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\Vocabularies;

use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\DefaultValue;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Deprecated;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Description;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Examples;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\IsReadOnly;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\IsWriteOnly;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Title;
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
            $metaData[Title::name()] = $this->title->value();
        }
        if ($this->description) {
            $metaData[Description::name()] = $this->description->value();
        }
        if ($this->defaultValue) {
            $metaData[DefaultValue::name()] = $this->defaultValue->value();
        }
        if ($this->deprecated) {
            $metaData[Deprecated::name()] = $this->deprecated->value();
        }
        if ($this->examples) {
            $metaData[Examples::name()] = $this->examples->value();
        }
        if ($this->readOnly) {
            $metaData[IsReadOnly::name()] = $this->readOnly->value();
        }
        if ($this->writeOnly) {
            $metaData[IsWriteOnly::name()] = $this->writeOnly->value();
        }

        return Arr::filter($metaData);
    }
}
