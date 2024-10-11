<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation as OperationAttribute;
use MohammadAlavi\LaravelOpenApi\Builders\ExtensionBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\CallbackBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\ParametersBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\RequestBodyBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\ResponseBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\SecurityBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\ServerBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\TagBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Operation;

final readonly class OperationBuilder
{
    public function __construct(
        private TagBuilder $tagBuilder,
        private ServerBuilder $serverBuilder,
        private ParametersBuilder $parametersBuilder,
        private RequestBodyBuilder $requestBodyBuilder,
        private ResponseBuilder $responseBuilder,
        private SecurityBuilder $securityBuilder,
        private CallbackBuilder $callbackBuilder,
        private ExtensionBuilder $extensionBuilder,
    ) {
    }

    // TODO: maybe we can abstract the usage of RouteInformation everywhere and use an interface instead
    public function build(RouteInformation $routeInformation): Operation
    {
        /** @var OperationAttribute|null $operation */
        $operation = $routeInformation->actionAttributes
            ->first(static fn (object $attribute): bool => $attribute instanceof OperationAttribute);

        $operationId = $operation?->id;
        $tags = $this->tagBuilder->build(Arr::wrap($operation?->tags));
        $security = $operation?->security ? $this->securityBuilder->build($operation?->security) : null;
        $method = $operation?->method ?? Str::lower($routeInformation->method);
        $summary = $operation?->summary;
        $description = $operation?->description;
        $deprecated = $operation?->deprecated;
        $servers = $this->serverBuilder->build(Arr::wrap($operation?->servers));
        $parameters = $this->parametersBuilder->build($routeInformation);
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
            ->parameters($parameters)
            ->requestBody($requestBody)
            ->responses(...$responses)
            ->callbacks(...$callbacks)
            ->servers(...$servers);
        if ($security) {
            $operation = $operation->security($security);
        }

        $this->extensionBuilder->build($operation, $routeInformation->actionAttributes);

        return $operation;
    }
}
