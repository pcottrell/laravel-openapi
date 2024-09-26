<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Contact extends ExtensibleObject
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

    protected function toArray(): array
    {
        return Arr::filter([
            'name' => $this->name,
            'url' => $this->url,
            'email' => $this->email,
        ]);
    }
}
