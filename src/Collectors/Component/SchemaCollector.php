<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Component;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Collectors\CollectionLocator;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SchemaFactory;
use MohammadAlavi\LaravelOpenApi\Generator;

final readonly class SchemaCollector
{
    public function __construct(
        private CollectionLocator $collectionLocator,
    ) {
    }

    public function collect(string $collection = Generator::COLLECTION_DEFAULT): Collection
    {
        return $this->collectionLocator->find($collection)
            ->filter(static fn ($class): bool => is_a($class, SchemaFactory::class, true) && is_a($class, Reusable::class, true))
            ->map(static function ($class) {
                /** @var SchemaFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values();
    }
}
