<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation as OperationAttribute;
use MohammadAlavi\LaravelOpenApi\Builders\ExtensionBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\CallbackBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\ParameterBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\RequestBodyBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\ResponseBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\SecurityRequirementBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\ServerBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\TagBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Operation;

final readonly class OperationBuilder
{
    public function __construct(
        private TagBuilder $tagBuilder,
        private ServerBuilder $serverBuilder,
        private ParameterBuilder $parameterBuilder,
        private RequestBodyBuilder $requestBodyBuilder,
        private ResponseBuilder $responseBuilder,
        private SecurityRequirementBuilder $securityRequirementBuilder,
        private CallbackBuilder $callbackBuilder,
        private ExtensionBuilder $extensionBuilder,
    ) {
    }

    public function build(array|Collection $routes): array
    {
        return collect($routes)
            ->map(
                fn (RouteInformation $routeInformation): Operation => $this->buildOperation($routeInformation),
            )->all();
    }

    // TODO: maybe we can abstract the usage of RouteInformation everywhere and use an interface instead
    private function buildOperation(RouteInformation $routeInformation): Operation
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
        ] = $this->parseOperationAttribute($routeInformation);

        $parameters = $this->parameterBuilder->build($routeInformation);
        $requestBody = $routeInformation->requestBodyAttribute()
            ? $this->requestBodyBuilder->build($routeInformation->requestBodyAttribute())
            : null;
        $responses = $this->responseBuilder->build(...$routeInformation->responseAttributes());
        $callbacks = $this->callbackBuilder->build($routeInformation);

        $operation = Operation::create()
            ->action($method)
            ->tags(...$tags)
            ->summary($summary)
            ->description($description)
            ->operationId($operationId)
            ->deprecated($deprecated)
            ->parameters(...$parameters)
            ->requestBody($requestBody)
            ->responses(...$responses)
            ->callbacks(...$callbacks)
            ->security($security)
            ->servers(...$servers);

        $this->extensionBuilder->build($operation, $routeInformation->actionAttributes);

        return $operation;
    }

    private function parseOperationAttribute(RouteInformation $routeInformation): array
    {
        $operation = $routeInformation->actionAttributes
            ->first(static fn (object $attribute): bool => $attribute instanceof OperationAttribute);

        return [
            $operation?->id,
            $this->tagBuilder->build(Arr::wrap($operation?->tags)),
            $this->securityRequirementBuilder->build($operation?->security),
            $operation?->method ?? Str::lower($routeInformation->method),
            $operation?->summary,
            $operation?->description,
            $operation?->deprecated,
            $this->serverBuilder->build(Arr::wrap($operation?->servers)),
        ];
    }
}
