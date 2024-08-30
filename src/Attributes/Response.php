<?php

namespace MohammadAlavi\LaravelOpenApi\Attributes;

use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Response
{
    public string $factory;

    public int|null $statusCode;

    public string|null $description;

    public function __construct(string $factory, int|null $statusCode = null, string|null $description = null)
    {
        $this->factory = class_exists($factory) ? $factory : app()->getNamespace() . 'OpenApi\\Responses\\' . $factory;

        if (!is_a($this->factory, ResponseFactory::class, true)) {
            throw new \InvalidArgumentException('Factory class must be an instance of ResponseFactory');
        }

        $this->statusCode = $statusCode;
        $this->description = $description;
    }
}
