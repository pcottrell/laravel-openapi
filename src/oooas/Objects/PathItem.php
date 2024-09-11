<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

/**
 * @property string|null $route
 * @property string|null $summary
 * @property string|null $description
 * @property Operation[]|null $operations
 * @property Server[]|null $servers
 * @property Parameter[]|null $parameters
 */
class PathItem extends BaseObject
{
    /**
     * @var string|null
     */
    protected $route;

    /**
     * @var string|null
     */
    protected $summary;

    /**
     * @var string|null
     */
    protected $description;

    /**
     * @var Operation[]|null
     */
    protected $operations;

    /**
     * @var Server[]|null
     */
    protected $servers;

    /**
     * @var Parameter[]|null
     */
    protected $parameters;

    /**
     * @return static
     */
    public function route(string|null $route): self
    {
        $instance = clone $this;

        $instance->route = $route;

        return $instance;
    }

    /**
     * @return static
     */
    public function summary(string|null $summary): self
    {
        $instance = clone $this;

        $instance->summary = $summary;

        return $instance;
    }

    /**
     * @return static
     */
    public function description(string|null $description): self
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    /**
     * @param Operation[] $operation
     *
     * @return static
     */
    public function operations(Operation ...$operation): self
    {
        $instance = clone $this;

        $instance->operations = $operation !== [] ? $operation : null;

        return $instance;
    }

    /**
     * @param Server[] $server
     *
     * @return static
     */
    public function servers(Server ...$server): self
    {
        $instance = clone $this;

        $instance->servers = $server !== [] ? $server : null;

        return $instance;
    }

    /**
     * @param Parameter[] $parameter
     *
     * @return static
     */
    public function parameters(Parameter ...$parameter): self
    {
        $instance = clone $this;

        $instance->parameters = $parameter !== [] ? $parameter : null;

        return $instance;
    }

    protected function generate(): array
    {
        $operations = [];
        foreach ($this->operations ?? [] as $operation) {
            $operations[$operation->action] = $operation->toArray();
        }

        return Arr::filter(
            array_merge($operations, [
                'summary' => $this->summary,
                'description' => $this->description,
                'servers' => $this->servers,
                'parameters' => $this->parameters,
            ]),
        );
    }
}
