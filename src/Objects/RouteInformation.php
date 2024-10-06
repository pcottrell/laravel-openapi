<?php

namespace MohammadAlavi\LaravelOpenApi\Objects;

use Illuminate\Routing\Controller;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MohammadAlavi\LaravelOpenApi\Attributes\Parameter;
use MohammadAlavi\LaravelOpenApi\Attributes\RequestBody;
use MohammadAlavi\LaravelOpenApi\Attributes\Response as ResponseAttribute;
use Webmozart\Assert\Assert;

class RouteInformation
{
    public string|null $domain = null;
    public string $method;
    public string $uri;
    public string|null $name = null;

    /** @var string|class-string<Controller> */
    public string $controller = 'Closure';

    /** @var Collection<int, Parameter> */
    public Collection $parameters;

    /** @var Collection<int, \Attribute> */
    public Collection $controllerAttributes;

    public string $action = 'Closure';

    /** @var \ReflectionParameter[] */
    public array $actionParameters = [];

    /** @var Collection<int, \Attribute> */
    public Collection $actionAttributes;

    public static function createFromRoute(Route $route): static
    {
        $method = collect($route->methods())
            ->map(static fn (string $value) => Str::lower($value))
            ->filter(static fn (string $value): bool => !in_array($value, ['head', 'options'], true))
            ->first();

        Assert::notNull(
            $method,
            'Unsupported HTTP method [' . implode(', ', $route->methods()) . '] for route: ' . $route->uri(),
        );

        return tap(new static(), static function (self $clone) use ($route, $method): void {

            preg_match_all('/{(.*?)}/', $route->uri, $parameters);
            $parameters = collect($parameters[1]);

            if (count($parameters) > 0) {
                $parameters = $parameters->map(static fn (string $parameter): array => [
                    'name' => Str::replaceLast('?', '', $parameter),
                    'required' => !Str::endsWith($parameter, '?'),
                ]);
            }

            if (static::isControllerAction($route)) {
                [$controller, $action] = Str::parseCallback($route->getAction('uses'));
                $clone->action = $action;
                $clone->controller = $controller;
            } elseif (!$route->getAction('uses') instanceof \Closure) {
                $clone->controller = $route->getAction()[0];
                $clone->action = '__invoke';
            } else {
                $clone->controller = 'Closure';
                $clone->action = 'Closure';
            }

            $clone->parameters = collect();
            $clone->actionAttributes = collect();
            if ('Closure' !== $clone->controller) {
                $reflectionClass = new \ReflectionClass($clone->controller);
                $reflectionMethod = $reflectionClass->getMethod($clone->action);
                $clone->actionParameters = $reflectionMethod->getParameters();

                $controllerAttributes = collect($reflectionClass->getAttributes())
                    ->map(
                        static fn (
                            \ReflectionAttribute $reflectionAttribute,
                        ): object => $reflectionAttribute->newInstance(),
                    );

                $clone->actionAttributes = collect($reflectionMethod->getAttributes())
                    ->map(
                        static fn (
                            \ReflectionAttribute $reflectionAttribute,
                        ): object => $reflectionAttribute->newInstance(),
                    );
            }

            $containsControllerLevelParameter = $clone->actionAttributes->contains(
                static fn (object $value): bool => $value instanceof Parameter,
            );

            $clone->parameters = $containsControllerLevelParameter ? collect() : $parameters;
            $clone->domain = $route->domain();
            $clone->method = $method;
            $clone->uri = Str::start($route->uri(), '/');
            $clone->name = $route->getName();
            $clone->controllerAttributes = $controllerAttributes ?? collect();
        });
    }

    /**
     * Checks whether the route's action is a controller.
     */
    private static function isControllerAction(Route $route): bool
    {
        return is_string($route->action['uses']) && ! static::isSerializedClosure($route);
    }

    /**
     * Determine if the route action is a serialized Closure.
     */
    private static function isSerializedClosure(Route $route): bool
    {
        return RouteAction::containsSerializedClosure($route->action);
    }

    /** @return Collection<int, ResponseAttribute> */
    public function responseAttributes(): Collection
    {
        return $this->actionAttributes
            ->filter(static fn (object $attribute): bool => $attribute instanceof ResponseAttribute);
    }

    public function requestBodyAttribute(): RequestBody|null
    {
        return $this->actionAttributes
            ->first(static fn (object $attribute): bool => $attribute instanceof RequestBody);
    }
}
