<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class PathItem extends ExtensibleObject
{
    protected string|null $route = null;
    protected string|null $summary = null;
    protected string|null $description = null;

    /** @var Operation[]|null */
    protected array|null $operations = null;

    /** @var Server[]|null */
    protected array|null $servers = null;

    /** @var Parameter[]|null */
    protected array|null $parameters = null;

    public function route(string|null $route): static
    {
        $clone = clone $this;

        $clone->route = $route;

        return $clone;
    }

    public function summary(string|null $summary): static
    {
        $clone = clone $this;

        $clone->summary = $summary;

        return $clone;
    }

    public function description(string|null $description): static
    {
        $clone = clone $this;

        $clone->description = $description;

        return $clone;
    }

    public function operations(Operation ...$operation): static
    {
        $clone = clone $this;

        $clone->operations = [] !== $operation ? $operation : null;

        return $clone;
    }

    public function servers(Server ...$server): static
    {
        $clone = clone $this;

        $clone->servers = [] !== $server ? $server : null;

        return $clone;
    }

    public function parameters(Parameter ...$parameter): static
    {
        $clone = clone $this;

        $clone->parameters = [] !== $parameter ? $parameter : null;

        return $clone;
    }

    protected function toArray(): array
    {
        $operations = [];
        foreach ($this->operations ?? [] as $operation) {
            $operations[$operation->action] = $operation->jsonSerialize();
        }

        return Arr::filter(
            [
                ...$operations,
                'summary' => $this->summary,
                'description' => $this->description,
                'servers' => $this->servers,
                'parameters' => $this->parameters,
            ],
        );
    }
}
