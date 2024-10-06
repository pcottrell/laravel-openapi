<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface\SimpleCreator;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\SimpleCreatorTrait;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class RequestBody extends ExtensibleObject implements SimpleCreator
{
    use SimpleCreatorTrait;

    protected string|null $description = null;

    /** @var MediaType[]|null */
    protected array|null $content = null;

    protected bool|null $required = null;

    public function description(string|null $description): static
    {
        $clone = clone $this;

        $clone->description = $description;

        return $clone;
    }

    public function content(MediaType ...$mediaType): static
    {
        $clone = clone $this;

        $clone->content = [] !== $mediaType ? $mediaType : null;

        return $clone;
    }

    public function required(bool|null $required = true): static
    {
        $clone = clone $this;

        $clone->required = $required;

        return $clone;
    }

    protected function toArray(): array
    {
        $content = [];
        foreach ($this->content ?? [] as $contentItem) {
            $content[$contentItem->key()] = $contentItem;
        }

        return Arr::filter([
            'description' => $this->description,
            'content' => [] !== $content ? $content : null,
            'required' => $this->required,
        ]);
    }
}
