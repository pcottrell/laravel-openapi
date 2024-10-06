<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;

final readonly class PathItemBuilder
{
    public function __construct(
        private OperationBuilder $operationBuilder,
    ) {
    }

    public function build(Collection $routes, string $uri): PathItem
    {
        $pathItem = PathItem::create()->path($uri);
        $operations = $this->operationBuilder->build($routes);

        return $pathItem->operations(...$operations);
    }
}
