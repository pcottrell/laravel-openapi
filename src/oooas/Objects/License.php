<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

/**
 * @property string|null $name
 * @property string|null $url
 */
class License extends BaseObject
{
    protected string|null $name = null;
    protected string|null $url = null;

    /** @return static */
    public function name(string|null $name): self
    {
        $instance = clone $this;

        $instance->name = $name;

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
            'name' => $this->name,
            'url' => $this->url,
        ]);
    }
}
