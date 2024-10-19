<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Collections\Path;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Paths;

final readonly class PathsBuilder
{
    public function __construct(
        private PathItemBuilder $pathItemBuilder,
    ) {
    }

    public function build(Collection $routeInfo): Paths
    {
        $paths = $routeInfo->groupBy(
            fn (RouteInformation $routeInformation): string => $routeInformation->uri(),
        )->map(
            fn (Collection $routeInformation, string $url): Path => Path::create(
                $url,
                $this->pathItemBuilder->build(...$routeInformation),
            ),
        )->values()
            ->toArray();

        return Paths::create(...$paths);
    }
}
