<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Encoding extends BaseObject
{
    protected string|null $contentType = null;

    /** @var Header[]|null */
    protected array|null $headers = null;

    protected string|null $style = null;
    protected bool|null $explode = null;
    protected bool|null $allowReserved = null;

    public function contentType(string|null $contentType): static
    {
        $instance = clone $this;

        $instance->contentType = $contentType;

        return $instance;
    }

    public function headers(Header ...$header): static
    {
        $instance = clone $this;

        $instance->headers = [] !== $header ? $header : null;

        return $instance;
    }

    public function style(string|null $style): static
    {
        $instance = clone $this;

        $instance->style = $style;

        return $instance;
    }

    public function explode(bool|null $explode = true): static
    {
        $instance = clone $this;

        $instance->explode = $explode;

        return $instance;
    }

    public function allowReserved(bool|null $allowReserved = true): static
    {
        $instance = clone $this;

        $instance->allowReserved = $allowReserved;

        return $instance;
    }

    protected function generate(): array
    {
        $headers = [];
        foreach ($this->headers ?? [] as $header) {
            $headers[$header->objectId] = $header;
        }

        return Arr::filter([
            'contentType' => $this->contentType,
            'headers' => [] !== $headers ? $headers : null,
            'style' => $this->style,
            'explode' => $this->explode,
            'allowReserved' => $this->allowReserved,
        ]);
    }
}
