<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Components;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Collectors\CollectionLocator;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory;
use MohammadAlavi\LaravelOpenApi\Generator;

/**
 * Collects all the callback factories that have Collection attribute with the given collection name.
 */
final readonly class CallbackCollector
{
    public function __construct(
        private CollectionLocator $collectionLocator,
    ) {
    }

    public function collect(string $collection = Generator::COLLECTION_DEFAULT): Collection
    {
        return $this->collectionLocator->find($collection)
            ->filter(static fn ($class): bool => is_a($class, CallbackFactory::class, true) && is_a($class, Reusable::class, true))
            ->map(static function ($class) {
                /** @var CallbackFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values();
    }
}
