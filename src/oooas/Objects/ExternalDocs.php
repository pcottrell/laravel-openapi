<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

/**
 * @property string|null $description
 * @property string|null $url
 */
class ExternalDocs extends BaseObject
{
    protected string|null $description = null;
    protected string|null $url = null;

    /** @return static */
    public function description(string|null $description): self
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    /** @return static */
    public function url(string|null $url): self
    {
        $instance = clone $this;

        $instance->url = $url;

        return $instance;
    }

    protected function generate(): array
    {
        return Arr::filter([
            'description' => $this->description,
            'url' => $this->url,
        ]);
    }
}
