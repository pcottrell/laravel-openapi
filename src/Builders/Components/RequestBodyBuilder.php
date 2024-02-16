<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\RequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\Generator;

class RequestBodyBuilder extends Builder
{
    public function build(string $collection = Generator::COLLECTION_DEFAULT): array
    {
        return $this->getAllClasses($collection)
            ->filter(static fn ($class) => is_a($class, RequestBodyFactory::class, true) && is_a($class, Reusable::class, true))
            ->map(static function ($class) {
                /** @var RequestBodyFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values()
            ->toArray();
    }
}
