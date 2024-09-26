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
        $instance = clone $this;

        $instance->route = $route;

        return $instance;
    }

    public function summary(string|null $summary): static
    {
        $instance = clone $this;

        $instance->summary = $summary;

        return $instance;
    }

    public function description(string|null $description): static
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    public function operations(Operation ...$operation): static
    {
        $instance = clone $this;

        $instance->operations = [] !== $operation ? $operation : null;

        return $instance;
    }

    public function servers(Server ...$server): static
    {
        $instance = clone $this;

        $instance->servers = [] !== $server ? $server : null;

        return $instance;
    }

    public function parameters(Parameter ...$parameter): static
    {
        $instance = clone $this;

        $instance->parameters = [] !== $parameter ? $parameter : null;

        return $instance;
    }

    protected function toArray(): array
    {
        $operations = [];
        foreach ($this->operations ?? [] as $operation) {
            $operations[$operation->action] = $operation->serialize();
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
