<?php

namespace MohammadAlavi\LaravelOpenApi\Factories;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection as CollectionAttribute;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Helpers\ClassMapGenerator;

abstract class ComponentBuilderFactory
{
    protected array $directories = [];

    public function __construct(array $directories)
    {
        $this->directories = $directories;
    }

    abstract public function build(): array;

    protected function getAllClasses(string $collection): Collection
    {
        return collect($this->directories)
            ->map(function (string $directory) {
                $map = ClassMapGenerator::createMap($directory);

                return array_keys($map);
            })
            ->flatten()
            ->filter(function (string $class) use ($collection) {
                $reflectionClass = new \ReflectionClass($class);
                $collectionAttributes = $reflectionClass->getAttributes(CollectionAttribute::class);

                if (0 === count($collectionAttributes) && Generator::COLLECTION_DEFAULT === $collection) {
                    return true;
                }

                if (0 === count($collectionAttributes)) {
                    return false;
                }

                /** @var CollectionAttribute $collectionAttribute */
                $collectionAttribute = $collectionAttributes[0]->newInstance();

                return
                    $collectionAttribute->name === ['*']
                    || in_array($collection, $collectionAttribute->name ?? [], true);
            });
    }
}
