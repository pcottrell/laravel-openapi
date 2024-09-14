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
        protected TagBuilder $tagBuilder,
        protected ServerBuilder $serverBuilder,
        protected ParameterBuilder $parameterBuilder,
        protected RequestBodyBuilder $requestBodyBuilder,
        protected ResponseBuilder $responseBuilder,
        protected SecurityRequirementBuilder $securityRequirementBuilder,
        protected CallbackBuilder $callbackBuilder,
        protected ExtensionBuilder $extensionBuilder,
    ) {
    }

    /** @param RouteInformation[]|Collection $routes */
    public function build(array|Collection $routes): array
    {
        $operations = [];

        /** @var RouteInformation[] $routes */
        foreach ($routes as $route) {
            [$operationId, $tags, $security, $method, $summary, $description, $deprecated, $servers] = $this->parseOperationAttribute($route);

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

            $operations[] = $operation;
        }

        return $operations;
    }

    private function parseOperationAttribute(RouteInformation $routeInformation): array
    {
        $operationId = null;
        $tags = [];
        $security = null;
        $method = Str::lower($routeInformation->method);
        $servers = [];
        $summary = null;
        $description = null;
        $deprecated = null;

        /** @var OperationAttribute|null $operation */
        $operation = $routeInformation->actionAttributes
            ->first(static fn (object $attribute): bool => $attribute instanceof OperationAttribute);

        if (!is_null($operation)) {
            $operationId = $operation->id;
            $tags = $this->tagBuilder->build(Arr::wrap($operation->tags));
            $security = $this->securityRequirementBuilder->build($operation->security);
            $method = $operation->method ?? $method;
            $servers = $this->serverBuilder->build(Arr::wrap($operation->servers));
            $summary = $operation->summary;
            $description = $operation->description;
            $deprecated = $operation->deprecated;
        }

        return [$operationId, $tags, $security, $method, $summary, $description, $deprecated, $servers];
    }
}
