<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Extensions;

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\JsonSerializable;
use Webmozart\Assert\Assert;

// TODO: make readonly if possible
// There was a problem with cloning that prevented me from making it readonly
final class Extensions extends JsonSerializable
{
    private array $extensions = [];

    private function __construct(
        Extension ...$extensions,
    ) {
        $this->add(...$extensions);
    }

    public function add(Extension ...$extension): self
    {
        foreach ($extension as $ext) {
            $this->extensions[$ext->name()] = $ext;
        }

        return $this;
    }

    public static function create(Extension ...$extensions): self
    {
        return new self(...$extensions);
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

    public function isEmpty(): bool
    {
        return empty($this->extensions);
    }

    protected function toArray(): array
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
