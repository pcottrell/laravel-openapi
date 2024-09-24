<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Contact extends BaseObject
{
    protected string|null $name = null;
    protected string|null $url = null;
    protected string|null $email = null;

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

    public function email(string|null $email): static
    {
        $instance = clone $this;

        $instance->email = $email;

        return $instance;
    }

    public function generate(): array
    {
        return Arr::filter([
            'name' => $this->name,
            'url' => $this->url,
            'email' => $this->email,
        ]);
    }
}
