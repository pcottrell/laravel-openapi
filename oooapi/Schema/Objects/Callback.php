<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\HasKey;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final class Callback extends ExtensibleObject implements HasKey
{
    public readonly string $key;
    public readonly string $expression;
    public readonly PathItem $pathItem;

    // TODO: I don't believe callback key is mandatory if callback is reusable/reference
    public static function create(string $key, string $expression, PathItem $pathItem): self
    {
        $instance = new self();
        $instance->key = $key;
        $instance->expression = $expression;
        $instance->pathItem = $pathItem;

        return $instance;
    }

    public function key(): string
    {
        return $this->key;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            $this->expression => $this->pathItem,
        ]);
    }
}
