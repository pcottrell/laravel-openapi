<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Parameter as ParameterAttribute;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ParameterFactory;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOAS\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;

class ParameterBuilder
{
    public function build(RouteInformation $routeInformation): array
    {
        $pathParameters = $this->buildPath($routeInformation);
        $attributedParameters = $this->buildAttribute($routeInformation);

        return $pathParameters->merge($attributedParameters)->toArray();
    }

    protected function buildPath(RouteInformation $routeInformation): Collection
    {
        return $routeInformation->parameters
            ->map(function (array $parameter) use ($routeInformation): Parameter|null {
                $schema = Schema::string();

                /** @var \ReflectionParameter|null $reflectionParameter */
                $reflectionParameter = collect($routeInformation->actionParameters)
                    ->first(
                        static fn (\ReflectionParameter $reflectionParameter): bool => $reflectionParameter
                                ->name === $parameter['name'],
                    );

                if ($reflectionParameter) {
                    // The reflected param has no type, so ignore (should be defined in a ParametersFactory instead)
                    if (is_null($reflectionParameter->getType())) {
                        return null;
                    }

                    $schema = $this->guessFromReflectionType($reflectionParameter->getType());
                }

                return Parameter::path()->name($parameter['name'])
                    ->required()
                    ->schema($schema);
            })
            ->filter();
    }

    private function guessFromReflectionType(\ReflectionType $reflectionType): Schema
    {
        return match ($reflectionType->getName()) {
            'int' => Schema::integer(),
            'bool' => Schema::boolean(),
            default => Schema::string(),
        };
    }

    protected function buildAttribute(RouteInformation $routeInformation): Collection
    {
        /** @var ParameterAttribute|null $parameters */
        $parameters = $routeInformation
            ->actionAttributes->first(
                static fn (object $attribute): bool => $attribute instanceof ParameterAttribute,
                [],
            );

        if ($parameters) {
            /** @var ParameterFactory $parametersFactory */
            $parametersFactory = app($parameters->factory);

            $parameters = $parametersFactory->build();
        }

        return collect($parameters);
    }
}
