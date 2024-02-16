<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Components;

use MohammadAlavi\LaravelOpenApi\Factories\SecuritySchemeFactory;
use MohammadAlavi\LaravelOpenApi\Generator;

class SecuritySchemeBuilder extends Builder
{
    public function build(string $collection = Generator::COLLECTION_DEFAULT): array
    {
        return $this->getAllClasses($collection)
            ->filter(static fn ($class) => is_a($class, SecuritySchemeFactory::class, true))
            ->map(static function ($class) {
                /** @var SecuritySchemeFactory $instance */
                $instance = app($class);

                return $instance->build();
            })
            ->values()
            ->toArray();
    }
}
