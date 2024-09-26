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
        $instance = clone $this;

        $instance->name = $name;

        return $instance;
    }

    public function url(string|null $url): static
    {
        $instance = clone $this;

        $instance->url = $url;

        return $instance;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'name' => $this->name,
            'url' => $this->url,
        ]);
    }
}
