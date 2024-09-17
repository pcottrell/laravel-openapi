<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;

class RouteCollector
{
    public function __construct(
        private readonly Router $router,
    ) {
    }

    /** @return Collection<int, RouteInformation> */
    public function getRoutes(): Collection
    {
        return collect($this->router->getRoutes())
            ->filter(static fn (Route $route): bool => 'Closure' !== $route->getActionName())
            ->map(static fn (Route $route): RouteInformation => RouteInformation::createFromRoute($route))
            ->filter(static function (RouteInformation $routeInformation): bool {
                $pathItem = $routeInformation->controllerAttributes
                    ->first(static fn (object $attribute): bool => $attribute instanceof Attributes\PathItem);

                $operation = $routeInformation->actionAttributes
                    ->first(static fn (object $attribute): bool => $attribute instanceof Attributes\Operation);

                return $pathItem && $operation;
            });
    }
}
