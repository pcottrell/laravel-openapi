<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\SimpleCreator;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\SimpleCreatorTrait;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

class ExternalDocs extends ExtensibleObject implements SimpleCreator
{
    use SimpleCreatorTrait;

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
