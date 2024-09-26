<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Link extends ExtensibleObject
{
    protected string|null $operationRef = null;
    protected string|null $operationId = null;
    protected string|null $description = null;
    protected Server|null $server = null;

    public function operationRef(string|null $operationRef): static
    {
        $instance = clone $this;

        $instance->operationRef = $operationRef;

        return $instance;
    }

    public function operationId(string|null $operationId): static
    {
        $instance = clone $this;

        $instance->operationId = $operationId;

        return $instance;
    }

    public function description(string|null $description): static
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    public function server(Server|null $server): static
    {
        $instance = clone $this;

        $instance->server = $server;

        return $instance;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'operationRef' => $this->operationRef,
            'operationId' => $this->operationId,
            'description' => $this->description,
            'server' => $this->server,
        ]);
    }
}
