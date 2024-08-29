<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Component;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory;
use MohammadAlavi\LaravelOpenApi\Generator;

final class ResponseCollector
{
    public function __construct(
        private readonly ClassCollector $componentCollector,
    ) {
    }

    public function collect(string $collection = Generator::COLLECTION_DEFAULT): Collection
    {
        return $this->componentCollector->collect($collection)
            ->filter(static fn ($class) => is_a($class, ResponseFactory::class, true) && is_a($class, Reusable::class, true))
            ->map(static function ($class) {
                /** @var ResponseFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values();
    }
}
