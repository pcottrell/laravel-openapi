<?php

namespace MohammadAlavi\LaravelOpenApi\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\ParameterFactory;

#[\Attribute(\Attribute::TARGET_METHOD)]
readonly class Parameter
{
    public string $factory;

    public function __construct(string $factory)
    {
        $this->factory = class_exists($factory) ? $factory : app()->getNamespace() . 'OpenApi\\Parameters\\' . $factory;

        if (!is_a($this->factory, ParameterFactory::class, true)) {
            throw new \InvalidArgumentException('Factory class must be an instance of ParametersFactory');
        }
    }
}
