<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Components;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Builders\Components\FilterStrategies\ReusableCallbackFilter;
use MohammadAlavi\LaravelOpenApi\Builders\Components\FilterStrategies\ReusableRequestBodyFilter;
use MohammadAlavi\LaravelOpenApi\Builders\Components\FilterStrategies\ReusableResponseFilter;
use MohammadAlavi\LaravelOpenApi\Builders\Components\FilterStrategies\ReusableSchemaFilter;
use MohammadAlavi\LaravelOpenApi\Builders\Components\FilterStrategies\ReusableSecuritySchemeFilter;
use MohammadAlavi\LaravelOpenApi\Services\CollectionLocator;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Components;

// TODO: add protection against invalid or duplicate component names
// For now they are overwritten silently
final readonly class ComponentsBuilder
{
    public function __construct(
        private CollectionLocator $collectionLocator,
    ) {
    }

    public function build(string $collection, array $middlewares = []): Components|null
    {
        $callbacks = $this->collectionLocator
            ->locateIn($this->getPathsFromConfig('callbacks'))
            ->use(new ReusableCallbackFilter())
            ->find($collection);
        $requestBodies = $this->collectionLocator
            ->locateIn($this->getPathsFromConfig('request_bodies'))
            ->use(new ReusableRequestBodyFilter())
            ->find($collection);
        $responses = $this->collectionLocator
            ->locateIn($this->getPathsFromConfig('responses'))
            ->use(new ReusableResponseFilter())
            ->find($collection);
        $schemas = $this->collectionLocator
            ->locateIn($this->getPathsFromConfig('schemas'))
            ->use(new ReusableSchemaFilter())
            ->find($collection);
        $securitySchemes = $this->collectionLocator
            ->locateIn($this->getPathsFromConfig('security_schemes'))
            ->use(new ReusableSecuritySchemeFilter())
            ->find($collection);

        $components = Components::create();

        $hasAnyObjects = false;

        if (count($callbacks) > 0) {
            $hasAnyObjects = true;

            $components = $components->callbacks(...$callbacks);
        }

        if (count($requestBodies) > 0) {
            $hasAnyObjects = true;

            $components = $components->requestBodies(...$requestBodies);
        }

        if (count($responses) > 0) {
            $hasAnyObjects = true;
            $components = $components->responses(...$responses);
        }

        if (count($schemas) > 0) {
            $hasAnyObjects = true;
            $components = $components->schemas(...$schemas);
        }

        if (count($securitySchemes) > 0) {
            $hasAnyObjects = true;
            $components = $components->securitySchemes(...$securitySchemes);
        }

        if (!$hasAnyObjects) {
            return null;
        }

        foreach ($middlewares as $middleware) {
            app($middleware)->after($components);
        }

        return $components;
    }

    private function getPathsFromConfig(string $type): array
    {
        $directories = config('openapi.locations.' . $type, []);

        foreach ($directories as &$directory) {
            $directory = glob($directory, GLOB_ONLYDIR);
        }

        return Collection::make($directories)
            ->flatten()
            ->unique()
            ->toArray();
    }
}
