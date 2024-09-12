<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

/**
 * @property string|null $contentType
 * @property Header[]|null $headers
 * @property string|null $style
 * @property bool|null $explode
 * @property bool|null $allowReserved
 */
class Encoding extends BaseObject
{
    protected string|null $contentType = null;

    /** @var Header[]|null */
    protected array|null $headers = null;

    protected string|null $style = null;
    protected bool|null $explode = null;
    protected bool|null $allowReserved = null;

    /** @return static */
    public function contentType(string|null $contentType): self
    {
        $instance = clone $this;

        $instance->contentType = $contentType;

        return $instance;
    }

    /**
     * @param Header[] $header
     *
     * @return static
     */
    public function headers(Header ...$header): self
    {
        $instance = clone $this;

        $instance->headers = [] !== $header ? $header : null;

        return $instance;
    }

    /** @return static */
    public function style(string|null $style): self
    {
        $instance = clone $this;

        $instance->style = $style;

        return $instance;
    }

    /** @return static */
    public function explode(bool|null $explode = true): self
    {
        $instance = clone $this;

        $instance->explode = $explode;

        return $instance;
    }

    /** @return static */
    public function allowReserved(bool|null $allowReserved = true): self
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
