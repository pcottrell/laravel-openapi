<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Component;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Collectors\CollectionLocator;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory;
use MohammadAlavi\LaravelOpenApi\Generator;

final readonly class ResponseCollector
{
    public function __construct(
        private CollectionLocator $collectionLocator,
    ) {
    }

    public function collect(string $collection = Generator::COLLECTION_DEFAULT): Collection
    {
        return $this->collectionLocator->find($collection)
            ->filter(static fn ($class): bool => is_a($class, ResponseFactory::class, true) && is_a($class, Reusable::class, true))
            ->map(static function ($class) {
                /** @var ResponseFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values();
    }
}
