<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection as CollectionAttribute;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\OperationBuilder;
use MohammadAlavi\LaravelOpenApi\Contracts\PathMiddleware;
use MohammadAlavi\LaravelOpenApi\Contracts\RouteCollector;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;

readonly class PathBuilder
{
    public function __construct(
        private OperationBuilder $operationBuilder,
        private RouteCollector $routeCollector,
    ) {
    }

    public function build(string $collection, PathMiddleware ...$middlewares): array
    {
        return $this->routeCollector->getRoutes()
            ->filter(fn (RouteInformation $route) => $this->shouldIncludeRoute($route, $collection))
            ->map(fn (RouteInformation $route) => $this->applyBeforeMiddleware($route, $middlewares))
            ->groupBy(static fn (RouteInformation $route) => $route->uri)
            ->map(fn (Collection $routes, $uri) => $this->createPathItem($routes, $uri))
            ->map(fn (PathItem $pathItem) => $this->applyAfterMiddleware($pathItem, $middlewares))
            ->values()
            ->toArray();
    }

    private function shouldIncludeRoute(RouteInformation $route, string $collection): bool
    {
        // TODO: use these docs to refactor and simplify this code
        // You can set the collection either on controller or per action (on each method)
        // the controller collection always overrides the action collection
        /** @var CollectionAttribute|null $collectionAttribute */
        $collectionAttribute = collect()
            ->merge($route->controllerAttributes)
            ->merge($route->actionAttributes)
            ->first(static fn (object $item) => $item instanceof CollectionAttribute);

        // if there is no collection attribute on the controller or action, then $collectionAttribute will be null
        // if (!$collectionAttribute) {
        //     dump('dead!', $collectionAttribute);
        // }
        // $collectionAttribute is the list of collections that this controller or action belongs to
        // $collectionAttribute are collection attributes added to [#Collection] on the controller or action
        // $collectionAttribute->name is an array of strings.
        //  Each string is a collection name (e.g. 'public', 'private', 'default')
        // $collectionAttribute->name is the name of the collections that this controller or action belongs to.
        // Maybe 'names' or 'collectionNames' was a more suitable name for this property.
        // -------
        // $collection comes in from documentation config types
        // It is the name of the current collection being built
        return (!$collectionAttribute && Generator::COLLECTION_DEFAULT === $collection)
            || ($collectionAttribute && in_array($collection, $collectionAttribute->name, true));
    }

    private function applyBeforeMiddleware(RouteInformation $route, array $middlewares): RouteInformation
    {
        foreach ($middlewares as $middleware) {
            $middleware->before($route);
        }

        return $route;
    }

    private function createPathItem(Collection $routes, string $uri): PathItem
    {
        $pathItem = PathItem::create()->route($uri);
        $operations = $this->operationBuilder->build($routes);

        return $pathItem->operations(...$operations);
    }

    private function applyAfterMiddleware(PathItem $pathItem, array $middlewares): PathItem
    {
        foreach ($middlewares as $middleware) {
            $pathItem = $middleware->after($pathItem);
        }

        return $pathItem;
    }
}
