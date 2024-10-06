<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use MohammadAlavi\LaravelOpenApi\Attributes\Callback as CallbackAttribute;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\CallbackFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\ReusableRefObj;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;

class CallbackBuilder
{
    public function build(RouteInformation $routeInformation): array
    {
        return $routeInformation->actionAttributes
            ->filter(static fn (object $attribute): bool => $attribute instanceof CallbackAttribute)
            ->map(static function (CallbackAttribute $callbackAttribute) {
                /** @var CallbackFactory $factory */
                $factory = app($callbackAttribute->factory);

                if ($factory instanceof ReusableRefObj) {
                    return $factory::ref();
                }

                return $factory->build();
            })
            ->values()
            ->toArray();
    }
}
