<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\PathMiddleware;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\RouteCollector;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;

final readonly class PathsBuilder
{
    public function __construct(
        private PathItemBuilder $pathItemBuilder,
        private RouteCollector $routeCollector,
    ) {
    }

    public function build(string $collection, PathMiddleware ...$pathMiddleware): array
    {
        return $this->routeCollector->whereInCollection($collection)
            ->map(
                fn (RouteInformation $routeInformation): RouteInformation => $this
                    ->applyBeforeMiddleware($routeInformation, $pathMiddleware),
            )->groupBy(static fn (RouteInformation $routeInformation): string => $routeInformation->uri)
            ->map(
                fn (Collection $routes, string $uri): PathItem => $this
                    ->pathItemBuilder->build($routes, $uri),
            )->map(
                fn (PathItem $pathItem): PathItem => $this
                    ->applyAfterMiddleware($pathItem, $pathMiddleware),
            )->values()
            ->toArray();
    }

    private function applyBeforeMiddleware(RouteInformation $routeInformation, array $middlewares): RouteInformation
    {
        foreach ($middlewares as $middleware) {
            $middleware->before($routeInformation);
        }

        return $routeInformation;
    }

    private function applyAfterMiddleware(PathItem $pathItem, array $middlewares): PathItem
    {
        foreach ($middlewares as $middleware) {
            $pathItem = $middleware->after($pathItem);
        }

        return $pathItem;
    }
}
