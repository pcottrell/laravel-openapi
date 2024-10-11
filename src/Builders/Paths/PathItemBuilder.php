<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths;

use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Operation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;

final readonly class PathItemBuilder
{
    public function __construct(
        private OperationBuilder $operationBuilder,
    ) {
    }

    public function build(RouteInformation ...$routes): PathItem
    {
        $pathItem = PathItem::create();
        $operations = collect($routes)
            ->map(
                fn (RouteInformation $routeInformation): Operation => $this->operationBuilder->build($routeInformation),
            )->all();

        return $pathItem->operations(...$operations);
    }
}
