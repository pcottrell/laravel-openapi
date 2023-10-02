<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Illuminate\Support\Collection;
use ReflectionParameter;
use MohammadAlavi\LaravelOpenApi\Attributes\Parameters;
use MohammadAlavi\LaravelOpenApi\Factories\ParametersFactory;
use MohammadAlavi\LaravelOpenApi\Helpers\SchemaHelper;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;

class ParameterBuilder
{
    public function build(RouteInformation $route): array
    {
        $pathParameters = $this->buildPath($route);
        $attributedParameters = $this->buildAttribute($route);

        return $pathParameters->merge($attributedParameters)->toArray();
    }

    protected function buildPath(RouteInformation $route): Collection
    {
        return collect($route->parameters)
            ->map(static function (array $parameter) use ($route) {
                $schema = Schema::string();

                /** @var ReflectionParameter|null $reflectionParameter */
                $reflectionParameter = collect($route->actionParameters)
                    ->first(static fn (ReflectionParameter $reflectionParameter) => $reflectionParameter->name === $parameter['name']);

                if ($reflectionParameter) {
                    // The reflected param has no type, so ignore (should be defined in a ParametersFactory instead)
                    if (null === $reflectionParameter->getType()) {
                        return null;
                    }

                    $schema = SchemaHelper::guessFromReflectionType($reflectionParameter->getType());
                }

                return Parameter::path()->name($parameter['name'])
                    ->required()
                    ->schema($schema);
            })
            ->filter();
    }

    protected function buildAttribute(RouteInformation $route): Collection
    {
        /** @var Parameters|null $parameters */
        $parameters = $route->actionAttributes->first(static fn ($attribute) => $attribute instanceof Parameters, []);

        if ($parameters) {
            /** @var ParametersFactory $parametersFactory */
            $parametersFactory = app($parameters->factory);

            $parameters = $parametersFactory->build();
        }

        return collect($parameters);
    }
}
