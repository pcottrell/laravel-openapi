<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

/**
 * @property string|null $url
 * @property string|null $description
 * @property ServerVariable[]|null $variables
 */
class Server extends BaseObject
{
    protected string|null $url = null;
    protected string|null $description = null;

    /**
     * @var ServerVariable[]|null
     */
    protected array|null $variables = null;

    /**
     * @return static
     */
    public function url(string|null $url): self
    {
        $instance = clone $this;

        $instance->url = $url;

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
     * @param ServerVariable[] $serverVariable
     *
     * @return static
     */
    public function variables(ServerVariable ...$serverVariable): self
    {
        $instance = clone $this;

        $instance->variables = [] !== $serverVariable ? $serverVariable : null;

        return $instance;
    }

    protected function generate(): array
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
