<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use MohammadAlavi\LaravelOpenApi\Attributes\Callback as CallbackAttribute;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Components\CallbackFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\ReusableRefObj;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInfo;

class CallbackBuilder
{
    public function build(RouteInfo $routeInformation): array
    {
        return $routeInformation->callbackAttributes()
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
