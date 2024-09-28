<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class License extends ExtensibleObject
{
    protected string|null $name = null;
    protected string|null $url = null;

    public function name(string|null $name): static
    {
        $clone = clone $this;

        $clone->name = $name;

        return $clone;
    }

    public function url(string|null $url): static
    {
        $clone = clone $this;

        $clone->url = $url;

        return $clone;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'name' => $this->name,
            'url' => $this->url,
        ]);
    }
}
