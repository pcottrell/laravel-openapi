<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\SchemaFactory;
use MohammadAlavi\LaravelOpenApi\Generator;

class SchemaBuilder extends Builder
{
    public function build(string $collection = Generator::COLLECTION_DEFAULT): array
    {
        return $this->getAllClasses($collection)
            ->filter(static function ($class) {
                return
                    is_a($class, SchemaFactory::class, true)
                    && is_a($class, Reusable::class, true);
            })
            ->map(static function ($class) {
                /** @var SchemaFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values()
            ->toArray();
    }
}
