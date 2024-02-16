<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\ResponseFactory;
use MohammadAlavi\LaravelOpenApi\Generator;

class ResponseBuilder extends Builder
{
    public function build(string $collection = Generator::COLLECTION_DEFAULT): array
    {
        return $this->getAllClasses($collection)
            ->filter(static fn ($class) => is_a($class, ResponseFactory::class, true) && is_a($class, Reusable::class, true))
            ->map(static function ($class) {
                /** @var ResponseFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values()
            ->toArray();
    }
}
