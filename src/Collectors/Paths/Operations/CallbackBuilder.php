<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations;

use MohammadAlavi\LaravelOpenApi\Attributes\Callback as CallbackAttribute;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;

class CallbackBuilder
{
    public function build(RouteInformation $routeInformation): array
    {
        return $routeInformation->actionAttributes
            ->filter(static fn (object $attribute): bool => $attribute instanceof CallbackAttribute)
            ->map(static function (CallbackAttribute $callbackAttribute) {
                /** @var CallbackFactory $factory */
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
