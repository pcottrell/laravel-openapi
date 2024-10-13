<?php

namespace MohammadAlavi\LaravelOpenApi\Collections;

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

    public static function create(Parameter|ReusableParameterFactory|self ...$parameter): self
    {
        $selfParams = collect($parameter)
            ->filter(static fn ($param) => $param instanceof self)
            ->map(static fn ($param) => $param->all())
            ->flatten();

        $parameters = collect($parameter)
            ->reject(static fn ($param) => $param instanceof self)
            ->merge($selfParams)
            ->map(static fn ($param) => $param instanceof ReusableParameterFactory ? $param::ref() : $param)
            ->toArray();

        return new self(...$parameters);
    }

    public function all(): array
    {
        return $this->parameters;
    }

    protected function toArray(): array
    {
        return $this->parameters;
    }
}
