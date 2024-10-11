<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Parameters as ParametersAttribute;
use MohammadAlavi\LaravelOpenApi\Collections\Parameters;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections\ParametersFactory;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;

class ParametersBuilder
{
    public function build(RouteInformation $routeInformation): Parameters|null
    {
        return $this->buildAttribute($routeInformation);

        // TODO: re-enable this feature
        // $pathParameters = $this->buildPath($routeInformation);
        // $attributedParameters = $this->buildAttribute($routeInformation);
        //
        // return $pathParameters->merge($attributedParameters)->toArray();
    }

    protected function buildAttribute(RouteInformation $routeInformation): Parameters|null
    {
        /** @var ParametersAttribute|null $parameters */
        $parameters = $routeInformation
            ->actionAttributes->first(
                static fn (object $attribute): bool => $attribute instanceof ParametersAttribute,
            );

        if ($parameters) {
            /** @var ParametersFactory $parametersFactory */
            $parametersFactory = app($parameters->factory);

            $parameters = $parametersFactory->build();
        }

        return $parameters;
    }

    protected function buildPath(RouteInformation $routeInformation): Collection
    {
        return $routeInformation->parameters
            ->map(function (array $parameter) use ($routeInformation): Parameter|null {
                $schema = Schema::string('string_test');

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

                    $schema = $this->guessFromReflectionType(
                        $reflectionParameter->getType(),
                        $reflectionParameter->getName(),
                    );
                }

                return Parameter::path()->name($parameter['name'])
                    ->required()
                    ->schema($schema);
            })
            ->filter();
    }

    private function guessFromReflectionType(\ReflectionType $reflectionType, string $name): Schema
    {
        return match ($reflectionType->getName()) {
            'int' => Schema::integer($name),
            'bool' => Schema::boolean($name),
            default => Schema::string($name),
        };
    }
}
