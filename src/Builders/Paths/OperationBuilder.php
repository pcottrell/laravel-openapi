<?php

namespace Vyuldashev\LaravelOpenApi\Builders\Paths;

use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Server;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Vyuldashev\LaravelOpenApi\Attributes\Operation as OperationAttribute;
use Vyuldashev\LaravelOpenApi\Builders\ExtensionBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\CallbackBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\ParameterBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\RequestBodyBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\ResponseBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\SecurityBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\TagBuilder;
use Vyuldashev\LaravelOpenApi\Factories\ServerFactory;
use Vyuldashev\LaravelOpenApi\Objects\Operation;
use Vyuldashev\LaravelOpenApi\Objects\RouteInformation;

class OperationBuilder
{
    public function __construct(
        protected TagBuilder $tagBuilder,
        protected ParameterBuilder $parameterBuilder,
        protected RequestBodyBuilder $requestBodyBuilder,
        protected ResponseBuilder $responseBuilder,
        protected SecurityBuilder $securityBuilder,
        protected CallbackBuilder $callbackBuilder,
        protected ExtensionBuilder $extensionBuilder,
    ) {
    }

    /**
     * @param RouteInformation[]|Collection $routes
     *
     * @throws InvalidArgumentException
     */
    public function build(array|Collection $routes): array
    {
        $operations = [];

        /** @var RouteInformation[] $routes */
        foreach ($routes as $route) {
            [$operationId, $tags, $security, $method, $summary, $description, $deprecated, $servers] = $this->parseAttribute($route);

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

    private function parseAttribute(RouteInformation $route): array
    {
        /** @var OperationAttribute|null $operationAttribute */
        $operationAttribute = $route->actionAttributes
            ->first(static fn (object $attribute) => $attribute instanceof OperationAttribute);

        $operationId = null;
        $tags = [];
        $security = null;
        $method = Str::lower($route->method);
        $summary = null;
        $description = null;
        $deprecated = null;
        $servers = [];

        if (!is_null($operationAttribute)) {
            $operationId = $operationAttribute->id;
            $tags = $this->tagBuilder->build(Arr::wrap($operationAttribute->tags));
            $security = $this->securityBuilder->build($route);
            $method = $operationAttribute->method ?? $method;
            $servers = collect($operationAttribute->servers ?? [])
                ->filter(static fn ($server) => app($server) instanceof ServerFactory)
                ->map(static fn (string $server): Server => app($server)->build())
                ->toArray();
            $summary = $operationAttribute->summary;
            $description = $operationAttribute->description;
            $deprecated = $operationAttribute->deprecated;
        }

        return [$operationId, $tags, $security, $method, $summary, $description, $deprecated, $servers];
    }
}
