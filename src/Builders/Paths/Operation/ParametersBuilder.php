<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Collections\ParameterCollection;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections\ParameterCollectionFactory;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInfo;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptor;
use MohammadAlavi\ObjectOrientedJSONSchema\Review\Schema;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;

class ParametersBuilder
{
    public function build(RouteInfo $routeInfo): ParameterCollection
    {
        $pathParameters = $this->buildPath($routeInfo);
        $attributedParameters = $this->buildAttribute($routeInfo);

        return ParameterCollection::create(
            $pathParameters,
            $attributedParameters,
        );
    }

    protected function buildPath(RouteInfo $routeInfo): ParameterCollection
    {
        /** @var Collection $parameters */
        $parameters = $routeInfo->parameters()
            ->map(function (array $parameter) use ($routeInfo): Parameter|null {
                $schema = Schema::string();

                /** @var \ReflectionParameter|null $reflectionParameter */
                $reflectionParameter = collect($routeInfo->actionParameters())
                    ->first(
                        static fn (\ReflectionParameter $reflectionParameter): bool => $reflectionParameter
                                ->name === $parameter['name'],
                    );

                if ($reflectionParameter) {
                    // The reflected param has no type, so ignore (should be defined in a ParametersFactory instead)
                    if (is_null($reflectionParameter->getType())) {
                        return null;
                    }

                    $schema = $this->guessFromReflectionType(
                        $reflectionParameter->getType(),
                    );
                }

                return Parameter::path()->name($parameter['name'])
                    ->required()
                    ->schema($schema);
            });
        $parameters = $parameters->filter(static fn (Parameter|null $parameter) => !is_null($parameter));

        return ParameterCollection::create(...$parameters->toArray());
    }

    private function guessFromReflectionType(\ReflectionType $reflectionType): Descriptor
    {
        return match ($reflectionType->getName()) {
            'int' => Schema::integer(),
            'bool' => Schema::boolean(),
            default => Schema::string(),
        };
    }

    protected function buildAttribute(RouteInfo $routeInfo): ParameterCollection
    {
        $parameters = $routeInfo->parametersAttribute();

        if ($parameters) {
            /** @var ParameterCollectionFactory $parametersFactory */
            $parametersFactory = app($parameters->factory);

            return $parametersFactory->build();
        }

        return ParameterCollection::create();
    }
}
