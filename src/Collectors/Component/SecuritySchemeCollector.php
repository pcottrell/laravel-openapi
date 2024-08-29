<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Component;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;
use MohammadAlavi\LaravelOpenApi\Generator;

final class SecuritySchemeCollector
{
    public function __construct(
        private readonly ClassCollector $componentCollector,
    ) {
    }

    public function collect(string $collection = Generator::COLLECTION_DEFAULT): Collection
    {
        return $this->componentCollector->collect($collection)
            ->filter(static fn ($class) => is_a($class, SecuritySchemeFactory::class, true))
            ->map(static function ($class) {
                /** @var SecuritySchemeFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values();
    }
}
