<?php

namespace Vyuldashev\LaravelOpenApi\Builders\Paths;

use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Server;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Vyuldashev\LaravelOpenApi\Attributes\Operation as OperationAttribute;
use Vyuldashev\LaravelOpenApi\Builders\ExtensionBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\CallbackBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\ParameterBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\RequestBodyBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\ResponseBuilder;
use Vyuldashev\LaravelOpenApi\Builders\Paths\Operation\SecurityRequirementBuilder;
use Vyuldashev\LaravelOpenApi\Factories\ServerFactory;
use Vyuldashev\LaravelOpenApi\Objects\Operation;
use Vyuldashev\LaravelOpenApi\RouteInformation;

class OperationBuilder
{
    public function __construct(
        protected CallbackBuilder $callbackBuilder,
        protected ParameterBuilder $parameterBuilder,
        protected RequestBodyBuilder $requestBodyBuilder,
        protected ResponseBuilder $responseBuilder,
        protected ExtensionBuilder $extensionBuilder,
        protected SecurityRequirementBuilder $securityBuilder
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
            /** @var OperationAttribute|null $operationAttribute */
            $operationAttribute = $route->actionAttributes
                ->first(static fn (object $attribute) => $attribute instanceof OperationAttribute);

            if (is_null($operationAttribute)) {
                continue;
            }

            $operationId = $operationAttribute->id;
            $tags = $operationAttribute->tags ?? [];
            $servers = collect($operationAttribute->servers ?? [])
                ->filter(static fn ($server) => app($server) instanceof ServerFactory)
                ->map(static fn (string $server): Server => app($server)->build())
                ->toArray();

            $parameters = $this->parameterBuilder->build($route);
            $requestBody = $this->requestBodyBuilder->build($route);
            $responses = $this->responseBuilder->build($route);
            $callbacks = $this->callbackBuilder->build($route);
            $security = $this->securityBuilder->build($route);

            $operation = Operation::create()
                ->action(Str::lower($operationAttribute->method ?? $route->method))
                ->tags(...$tags)
                ->deprecated($operationAttribute->deprecated)
                ->description($operationAttribute->description)
                ->summary($operationAttribute->summary)
                ->operationId($operationId)
                ->parameters(...$parameters)
                ->requestBody($requestBody)
                ->responses(...$responses)
                ->callbacks(...$callbacks)
                ->servers(...$servers);

            if ($security->shouldSkipGlobalSecurity()) {
                $operation = $operation->noSecurity();
            } else {
                $operation = $operation->security($security);
            }

            $this->extensionBuilder->build($operation, $route->actionAttributes);

            $operations[] = $operation;
        }

        return $operations;
    }
}
