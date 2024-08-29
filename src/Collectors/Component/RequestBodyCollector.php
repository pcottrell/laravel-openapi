<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Component;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\RequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\Generator;

final class RequestBodyCollector
{
    public function __construct(
        private readonly ClassCollector $componentCollector,
    ) {
    }

    public function collect(string $collection = Generator::COLLECTION_DEFAULT): Collection
    {
        return $this->componentCollector->collect($collection)
            ->filter(static fn ($class) => is_a($class, RequestBodyFactory::class, true) && is_a($class, Reusable::class, true))
            ->map(static function ($class) {
                /** @var RequestBodyFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values();
    }
}
