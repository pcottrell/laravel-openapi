<?php

namespace MohammadAlavi\LaravelOpenApi\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Collection
{
    /** @var string|string[] */
    public string|array $name;

    public function __construct(string|array $name = 'default')
    {
        $this->name = $this->prepareCollection($name);
    }

    private function prepareCollection(string|array $name): array
    {
        if (is_string($name)) {
            return [$this->getString($name)];
        }

        return array_map(function (string $item): string {
            return $this->getString($item);
        }, $name);
    }

    private function getString(string $name): string
    {
        if ($this->isStringable($name)) {
            return (string) (new $name());
        }

        return $name;
    }

    private function isStringable(string $name): bool
    {
        return class_exists($name) && is_subclass_of($name, \Stringable::class, true);
    }
}
