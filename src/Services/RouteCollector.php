<?php

namespace MohammadAlavi\LaravelOpenApi\Services;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection as CollectionAttribute;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation;
use MohammadAlavi\LaravelOpenApi\Attributes\PathItem;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\RouteCollector as RouteCollectorContract;
use MohammadAlavi\LaravelOpenApi\Generator;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;

final class RouteCollector extends Collection implements RouteCollectorContract
{
    public function __construct(
        private readonly Router $router,
    ) {
        parent::__construct($this->router->getRoutes());
        $this->items = $this->filter(static fn (Route $route): bool => 'Closure' !== $route->getActionName())
            ->map(static fn (Route $route): RouteInformation => RouteInformation::createFromRoute($route))
            ->filter(static function (RouteInformation $routeInformation): bool {
                $pathItem = $routeInformation->controllerAttributes
                    ->first(static fn (object $attribute): bool => $attribute instanceof PathItem);

                $operation = $routeInformation->actionAttributes
                    ->first(static fn (object $attribute): bool => $attribute instanceof Operation);

                return $pathItem && $operation;
            });
    }

    public function whereInCollection(string $collection): self
    {
        return $this->filter(
                fn (RouteInformation $routeInformation): bool => $this
                ->isInCollection($routeInformation, $collection),
            );
    }

    private function isInCollection(RouteInformation $routeInformation, string $collection): bool
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
}
