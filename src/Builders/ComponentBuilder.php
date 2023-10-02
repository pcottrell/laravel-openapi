<?php

namespace MohammadAlavi\LaravelOpenApi\Builders;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Components;
use MohammadAlavi\LaravelOpenApi\Builders\Components\CallbackBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Components\RequestBodyBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Components\ResponseBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Components\SchemaBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Components\SecuritySchemeBuilder;
use MohammadAlavi\LaravelOpenApi\Generator;

class ComponentBuilder
{
    public function __construct(
        private readonly CallbackBuilder $callbackBuilder,
        private readonly RequestBodyBuilder $requestBodyBuilder,
        private readonly ResponseBuilder $responseBuilder,
        private readonly SchemaBuilder $schemaBuilder,
        private readonly SecuritySchemeBuilder $securitySchemeBuilder
    ) {
    }

    public function build(
        string $collection = Generator::COLLECTION_DEFAULT,
        array $middlewares = []
    ): Components|null {
        $callbacks = $this->callbackBuilder->build($collection);
        $requestBodies = $this->requestBodyBuilder->build($collection);
        $responses = $this->responseBuilder->build($collection);
        $schemas = $this->schemaBuilder->build($collection);
        $securitySchemes = $this->securitySchemeBuilder->build($collection);

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
}
