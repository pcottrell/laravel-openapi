<?php

namespace MohammadAlavi\LaravelOpenApi\Reusable\FilterStrategies;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableResponseFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\FilterStrategy;

final readonly class ReusableResponseFilter implements FilterStrategy
{
    public function apply(Collection $data): Collection
    {
        return $data->filter(
            static fn (string $class): bool => is_a($class, ReusableResponseFactory::class, true),
        );
    }
}
