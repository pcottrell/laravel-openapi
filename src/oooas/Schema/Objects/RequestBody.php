<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class RequestBody extends ExtensibleObject
{
    protected string|null $description = null;

    /** @var MediaType[]|null */
    protected array|null $content = null;

    protected bool|null $required = null;

    public function description(string|null $description): static
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    public function content(MediaType ...$mediaType): static
    {
        $instance = clone $this;

        $instance->content = [] !== $mediaType ? $mediaType : null;

        return $instance;
    }

    public function required(bool|null $required = true): static
    {
        $instance = clone $this;

        $instance->required = $required;

        return $instance;
    }

    protected function toArray(): array
    {
        $content = [];
        foreach ($this->content ?? [] as $contentItem) {
            $content[$contentItem->mediaType] = $contentItem;
        }

        return Arr::filter([
            'description' => $this->description,
            'content' => [] !== $content ? $content : null,
            'required' => $this->required,
        ]);
    }
}
