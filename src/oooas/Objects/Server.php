<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Server extends BaseObject
{
    protected string|null $url = null;
    protected string|null $description = null;

    /** @var ServerVariable[]|null */
    protected array|null $variables = null;

    public function url(string|null $url): static
    {
        $instance = clone $this;

        $instance->url = $url;

        return $instance;
    }

    public function description(string|null $description): static
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    public function variables(ServerVariable ...$serverVariable): static
    {
        $instance = clone $this;

        $instance->variables = [] !== $serverVariable ? $serverVariable : null;

        return $instance;
    }

    public function generate(): array
    {
        $variables = [];
        foreach ($this->variables ?? [] as $variable) {
            $variables[$variable->objectId] = $variable->toArray();
        }

        return Arr::filter([
            'url' => $this->url,
            'description' => $this->description,
            'variables' => [] !== $variables ? $variables : null,
        ]);
    }
}
