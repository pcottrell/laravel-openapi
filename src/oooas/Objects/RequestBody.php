<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

/**
 * @property string|null $description
 * @property MediaType[]|null $content
 * @property bool|null $required
 */
class RequestBody extends BaseObject
{
    protected string|null $description = null;

    /**
     * @var MediaType[]|null
     */
    protected array|null $content = null;

    protected bool|null $required = null;

    /**
     * @return static
     */
    public function description(string|null $description): self
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    /**
     * @param MediaType[] $mediaType
     *
     * @return static
     */
    public function content(MediaType ...$mediaType): self
    {
        $instance = clone $this;

        $instance->content = [] !== $mediaType ? $mediaType : null;

        return $instance;
    }

    /**
     * @return static
     */
    public function required(bool|null $required = true): self
    {
        $instance = clone $this;

        $instance->required = $required;

        return $instance;
    }

    protected function generate(): array
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
