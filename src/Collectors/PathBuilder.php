<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection as CollectionAttribute;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\OperationBuilder;
use MohammadAlavi\LaravelOpenApi\Contracts\PathMiddleware;
use MohammadAlavi\LaravelOpenApi\Contracts\RouteCollector;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;

readonly class PathBuilder
{
    public function __construct(
        private OperationBuilder $operationBuilder,
        private RouteCollector $routeCollector,
    ) {
    }

    public function build(string $collection, PathMiddleware ...$pathMiddleware): array
    {
        return $this->routeCollector->getRoutes()
            ->filter(fn (RouteInformation $routeInformation): bool => $this->shouldIncludeRoute($routeInformation, $collection))
            ->map(fn (RouteInformation $routeInformation): RouteInformation => $this->applyBeforeMiddleware($routeInformation, $pathMiddleware))
            ->groupBy(static fn (RouteInformation $routeInformation): string => $routeInformation->uri)
            ->map(fn (Collection $routes, string $uri): PathItem => $this->createPathItem($routes, $uri))
            ->map(fn (PathItem $pathItem): PathItem => $this->applyAfterMiddleware($pathItem, $pathMiddleware))
            ->values()
            ->toArray();
    }

    private function shouldIncludeRoute(RouteInformation $routeInformation, string $collection): bool
    {
        // TODO: use these docs to refactor and simplify this code
        // You can set the collection either on controller or per action (on each method)
        // the controller collection always overrides the action collection
        /** @var CollectionAttribute|null $collectionAttribute */
        $collectionAttribute = collect()
            ->merge($routeInformation->controllerAttributes)
            ->merge($routeInformation->actionAttributes)
            ->first(static fn (object $item): bool => $item instanceof CollectionAttribute);

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

    private function applyBeforeMiddleware(RouteInformation $routeInformation, array $middlewares): RouteInformation
    {
        foreach ($middlewares as $middleware) {
            $middleware->before($routeInformation);
        }

        return $routeInformation;
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
