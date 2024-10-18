<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Collections\Path;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\PathMiddleware;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\RouteCollector;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Paths;

final readonly class PathsBuilder
{
    public function __construct(
        private PathItemBuilder $pathItemBuilder,
        private RouteCollector $routeCollector,
    ) {
    }

    public function build(string $collection, PathMiddleware ...$pathMiddleware): Paths
    {
        // TODO: Separate the collecting logic into a separate class
        $paths = $this->routeCollector->whereInCollection($collection)
            ->map(
                fn (RouteInformation $routeInformation): RouteInformation => $this
                    ->applyBeforeMiddleware($routeInformation, ...$pathMiddleware),
            )->groupBy(static fn (RouteInformation $routeInformation): string => $routeInformation->url())
            ->map(
                fn (Collection $routeInformation, string $url): Path => Path::create(
                    $url,
                    $this->pathItemBuilder->build(...$routeInformation),
                ),
            )->map(
                fn (Path $path): Path => $this
                    ->applyAfterMiddlewares($path, ...$pathMiddleware),
            )->values()
            ->toArray();

        return Paths::create(...$paths);
    }

    private function applyBeforeMiddleware(
        RouteInformation $routeInformation,
        PathMiddleware ...$pathMiddleware,
    ): RouteInformation {
        return app(Pipeline::class)
            ->send($routeInformation)
            ->through($pathMiddleware)
            ->via('before')
            ->thenReturn();
    }

    private function applyAfterMiddlewares(
        Path $path,
        PathMiddleware ...$pathMiddleware,
    ): Path {
        return app(Pipeline::class)
            ->send($path)
            ->through($pathMiddleware)
            ->via('after')
            ->thenReturn();
    }
}
