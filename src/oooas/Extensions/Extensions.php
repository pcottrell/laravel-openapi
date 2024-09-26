<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Extensions;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Serializable;
use Webmozart\Assert\Assert;

final class Extensions implements Serializable
{
    private function __construct(
        /** @var Extension[] */
        private array $extensions,
    ) {
    }

    public static function create(): self
    {
        return new self([]);
    }

    public function add(Extension $extension): self
    {
        $this->extensions[$extension->name] = $extension;

        return $this;
    }

    public function remove(string $name): self
    {
        Assert::keyExists($this->extensions, $name, 'Extension not found: ' . $name);

        unset($this->extensions[$name]);

        return $this;
    }

    public function get(string $name): Extension
    {
        Assert::keyExists($this->extensions, $name, 'Extension not found: ' . $name);

        return $this->extensions[$name];
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->extensions);
    }

    /** @return Extension[] */
    public function all(): array
    {
        return array_values($this->extensions);
    }

    public function jsonSerialize(): array
    {
        return $this->serialize();
    }

    public function serialize(): array
    {
        return $this->toArray();
    }

    protected function toArray(): array
    {
        return array_reduce($this->extensions, static function (array $carry, Extension $extension) {
            return array_merge($carry, $extension->serialize());
        }, []);
    }
}
