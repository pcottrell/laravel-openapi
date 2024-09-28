<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class ExternalDocs extends ExtensibleObject
{
    protected string|null $description = null;
    protected string|null $url = null;

    public function description(string|null $description): static
    {
        $clone = clone $this;

        $clone->description = $description;

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
            'description' => $this->description,
            'url' => $this->url,
        ]);
    }
}
