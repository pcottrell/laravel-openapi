<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Server extends ExtensibleObject
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

    protected function toArray(): array
    {
        $variables = [];
        foreach ($this->variables ?? [] as $variable) {
            $variables[$variable->objectId] = $variable->jsonSerialize();
        }

        return Arr::filter([
            'url' => $this->url,
            'description' => $this->description,
            'variables' => [] !== $variables ? $variables : null,
        ]);
    }
}
