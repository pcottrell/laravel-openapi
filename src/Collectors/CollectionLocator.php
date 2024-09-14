<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection as CollectionAttribute;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Helpers\ClassMapGenerator;

/**
 * Collects all classes that have the Collection attribute with the given collection name.
 */
final readonly class CollectionLocator
{
    public function __construct(
        private array $directories,
    ) {
    }

    public function find(string $collection = Generator::COLLECTION_DEFAULT): Collection
    {
        return collect($this->directories)
            ->map(static function (string $directory): array {
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

                return ['*'] === $collectionAttribute->name || in_array($collection, $collectionAttribute->name ?? [], true);
            });
    }
}
