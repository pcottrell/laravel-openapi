<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Paths;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation as OperationAttribute;
use MohammadAlavi\LaravelOpenApi\Collectors\ExtensionBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\CallbackBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\ParameterBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\RequestBodyBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\ResponseBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\SecurityRequirementBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\ServerBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\TagBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\Operation;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;

class OperationBuilder
{
    public function __construct(
        private readonly TagBuilder $tagBuilder,
        private readonly ServerBuilder $serverBuilder,
        private readonly ParameterBuilder $parameterBuilder,
        private readonly RequestBodyBuilder $requestBodyBuilder,
        private readonly ResponseBuilder $responseBuilder,
        private readonly SecurityRequirementBuilder $securityRequirementBuilder,
        private readonly CallbackBuilder $callbackBuilder,
        private readonly ExtensionBuilder $extensionBuilder,
    ) {
    }

    public function build(array|Collection $routes): array
    {
        return collect($routes)->map(fn (RouteInformation $route) => $this->buildOperation($route))->all();
    }

    private function buildOperation(RouteInformation $route): Operation
    {
        [
            $operationId,
            $tags,
            $security,
            $method,
            $summary,
            $description,
            $deprecated,
            $servers
        ] = $this->parseOperationAttribute($route);

        $parameters = $this->parameterBuilder->build($route);
        $requestBody = $this->requestBodyBuilder->build($route);
        $responses = $this->responseBuilder->build($route);
        $callbacks = $this->callbackBuilder->build($route);

        $operation = Operation::create()
            ->action($method)
            ->tags(...$tags)
            ->summary($summary)
            ->description($description)
            ->deprecated($deprecated)
            ->operationId($operationId)
            ->parameters(...$parameters)
            ->requestBody($requestBody)
            ->responses(...$responses)
            ->callbacks(...$callbacks)
            ->security($security)
            ->servers(...$servers);

        $this->extensionBuilder->build($operation, $route->actionAttributes);

        return $operation;
    }

    private function parseOperationAttribute(RouteInformation $route): array
    {
        $operation = $route->actionAttributes
            ->first(static fn (object $attribute) => $attribute instanceof OperationAttribute);

        return [
            $operation?->id,
            $this->tagBuilder->build(Arr::wrap($operation?->tags)),
            $this->securityRequirementBuilder->build($operation?->security),
            $operation?->method ?? Str::lower($route->method),
            $operation?->summary,
            $operation?->description,
            $operation?->deprecated,
            $this->serverBuilder->build(Arr::wrap($operation?->servers)),
        ];
    }
}
