<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface\SimpleCreator;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\SimpleCreatorTrait;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Server extends ExtensibleObject implements SimpleCreator
{
    use SimpleCreatorTrait;

    protected string|null $url = null;
    protected string|null $description = null;

    /** @var ServerVariable[]|null */
    protected array|null $variables = null;

    public function url(string|null $url): static
    {
        $clone = clone $this;

        $clone->url = $url;

        return $clone;
    }

    public function description(string|null $description): static
    {
        $clone = clone $this;

        $clone->description = $description;

        return $clone;
    }

    public function variables(ServerVariable ...$serverVariable): static
    {
        $clone = clone $this;

        $clone->variables = [] !== $serverVariable ? $serverVariable : null;

        return $clone;
    }

    protected function toArray(): array
    {
        $variables = [];
        foreach ($this->variables ?? [] as $variable) {
            $variables[$variable->key()] = $variable->jsonSerialize();
        }

        return Arr::filter([
            'url' => $this->url,
            'description' => $this->description,
            'variables' => [] !== $variables ? $variables : null,
        ]);
    }
}
