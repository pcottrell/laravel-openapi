<?php

namespace MohammadAlavi\LaravelOpenApi\Attributes;

use MohammadAlavi\LaravelOpenApi\Generator;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Collection
{
    /** @var string|string[] */
    public string|array $name;

    public function __construct(string|array $name = Generator::COLLECTION_DEFAULT)
    {
        $this->name = $this->prepareCollection($name);
    }

    private function prepareCollection(string|array $name): array
    {
        if (is_string($name)) {
            return [$this->getString($name)];
        }

        return array_map(fn (string $item): string => $this->getString($item), $name);
    }

    private function getString(string $name): string
    {
        if ($this->isStringable($name)) {
            /* @var class-string<\Stringable> $name */
            return (string) (new $name());
        }

        return $name;
    }

    private function isStringable(string $name): bool
    {
        return class_exists($name) && is_subclass_of($name, \Stringable::class);
    }
}
