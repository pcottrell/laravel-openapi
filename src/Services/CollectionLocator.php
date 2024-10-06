<?php

namespace MohammadAlavi\LaravelOpenApi\Services;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection as CollectionAttribute;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\FilterStrategy;
use MohammadAlavi\LaravelOpenApi\Generator;

final class CollectionLocator
{
    public function __construct(
        private array|null $directories = null,
        private FilterStrategy|null $strategy = null,
    ) {
    }

    public function find(string $collection): Collection
    {
        $result = collect($this->directories)
            ->map(static function (string $directory): array {
                // TODO: can we make this dependency clear? And not use it as static? This hides the dependency.
                $map = ClassMapGenerator::createMap($directory);

                return array_keys($map);
            })
            ->flatten()
            ->filter(function (string $class) use ($collection): bool {
                $reflectionClass = new \ReflectionClass($class);
                $collectionAttributes = $reflectionClass->getAttributes(CollectionAttribute::class);

                if (Generator::COLLECTION_DEFAULT === $collection && [] === $collectionAttributes) {
                    return true;
                }

                if ([] === $collectionAttributes) {
                    return false;
                }

                /** @var CollectionAttribute $collectionAttribute */
                $collectionAttribute = $collectionAttributes[0]->newInstance();

                return ['*'] === $collectionAttribute->name
                    || in_array(
                        $collection,
                        $collectionAttribute->name ?? [],
                        true,
                    );
            });

        if ($this->strategy) {
            $result = $this->strategy->apply($result);
        }

        // TODO: refactor: maybe we can decouple this responsibility?
        // you know, instantiating the factories
        return $result
            ->map(static fn (string $factory) => app($factory)->build())
            ->values();
    }

    public function use(FilterStrategy $strategy): self
    {
        $clone = clone $this;

        $clone->strategy = $strategy;

        return $clone;
    }

    public function locateIn(array $directories): self
    {
        $clone = clone $this;

        $clone->directories = $directories;

        return $clone;
    }
}
