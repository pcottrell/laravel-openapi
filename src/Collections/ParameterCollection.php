<?php

namespace MohammadAlavi\LaravelOpenApi\Collections;

use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\ParameterBuilder;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableParameterFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Parameter;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Reference;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\JsonSerializable;

final class ParameterCollection extends JsonSerializable
{
    private readonly array $parameters;

    private function __construct(
        Parameter|Reference ...$parameter,
    ) {
        $this->parameters = $parameter;
    }

    public function merge(self $parameterCollection): self
    {
        return self::create(
            ...$this->parameters,
            ...$parameterCollection->parameters,
        );
    }

    public static function create(Parameter|self|ReusableParameterFactory ...$parameter): self
    {
        $params = collect($parameter)
            ->map(
                static fn ($param) => $param instanceof self ? $param->parameters : $param,
            )->flatten()
            ->map(
                static fn ($param) => app(ParameterBuilder::class)->build($param),
            )->toArray();

        return new self(...$params);
    }

    protected function toArray(): array
    {
        return $this->parameters;
    }
}
