<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Extensions;

use Webmozart\Assert\Assert;

final class Extensions implements \JsonSerializable
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

    public function add(Extension ...$extension): self
    {
        foreach ($extension as $ext) {
            $this->extensions[$ext->name] = $ext;
        }

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
        return $this->toArray();
    }

    private function toArray(): array
    {
        return array_reduce(
            $this->extensions,
            static fn (
                array $carry,
                Extension $extension,
            ): array => array_merge(
                $carry,
                $extension->jsonSerialize(),
            ),
            [],
        );
    }
}
