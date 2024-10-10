<?php

namespace MohammadAlavi\LaravelOpenApi\Collections;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableParameterFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\BaseObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Reference;

final class Parameters extends BaseObject
{
    private array $parameters;

    private function __construct(
        Parameter|Reference ...$parameters,
    ) {
        $this->parameters = $parameters;
    }

    public function merge(self $parameters): self
    {
        return self::create(
            ...$this->parameters,
            ...$parameters->parameters,
        );
    }

    public static function create(Parameter|self|ReusableParameterFactory ...$parameters): self
    {
        $params = collect($parameters)
            ->map(
                static fn ($parameter) => $parameter instanceof self
                    ? $parameter->parameters
                    : $parameter,
            )->flatten()
            ->map(
                static fn ($parameter) => $parameter instanceof ReusableParameterFactory
                    ? $parameter::ref()
                    : $parameter,
            )->toArray();


        return new self(...$params);
    }

    public function toArray(): array
    {
        return $this->parameters;
    }
}
