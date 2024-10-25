<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths;

use MohammadAlavi\LaravelOpenApi\Objects\RouteInfo;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Operation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;

final readonly class PathItemBuilder
{
    public function __construct(
        private OperationBuilder $operationBuilder,
    ) {
    }

    public function build(RouteInfo ...$routes): PathItem
    {
        $pathItem = PathItem::create();
        $operations = collect($routes)
            ->map(
                fn (RouteInfo $routeInformation): Operation => $this->operationBuilder->build($routeInformation),
            )->all();

        return $pathItem->operations(...$operations);
    }
}
