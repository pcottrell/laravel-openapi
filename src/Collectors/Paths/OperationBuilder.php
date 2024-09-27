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
        return collect($routes)->map(fn (RouteInformation $routeInformation): \MohammadAlavi\LaravelOpenApi\Objects\Operation => $this->buildOperation($routeInformation))->all();
    }

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
        $requestBody = $this->requestBodyBuilder->build($routeInformation);
        $responses = $this->responseBuilder->build($routeInformation);
        $callbacks = $this->callbackBuilder->build($routeInformation);

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
