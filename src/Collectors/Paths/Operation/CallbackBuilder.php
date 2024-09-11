<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operation;

use MohammadAlavi\LaravelOpenApi\Attributes\Callback as CallbackAttribute;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;

class CallbackBuilder
{
    public function build(RouteInformation $routeInformation): array
    {
        return $routeInformation->actionAttributes
            ->filter(static fn (object $attribute): bool => $attribute instanceof CallbackAttribute)
            ->map(static function (CallbackAttribute $callbackAttribute) {
                $factory = app($callbackAttribute->factory);
                $pathItem = $factory->build();

                if ($factory instanceof Reusable) {
                    return PathItem::ref('#/components/callbacks/' . $pathItem->objectId);
                }

                return $pathItem;
            })
            ->values()
            ->toArray();
    }
}
