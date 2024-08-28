<?php

namespace MohammadAlavi\LaravelOpenApi\Concerns;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use InvalidArgumentException;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\CallbackFactory;
use MohammadAlavi\LaravelOpenApi\Factories\ParametersFactory;
use MohammadAlavi\LaravelOpenApi\Factories\RequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\Factories\ResponseFactory;
use MohammadAlavi\LaravelOpenApi\Factories\SchemaFactory;
use MohammadAlavi\LaravelOpenApi\Factories\SecuritySchemeFactory;

trait Referencable
{
    public static function ref(string $objectId = null): Schema
    {
        $instance = app(static::class);

        if (!$instance instanceof Reusable) {
            throw new InvalidArgumentException('"' . static::class . '" must implement "' . Reusable::class . '" in order to be referencable.');
        }

        $baseRef = null;

        if ($instance instanceof CallbackFactory) {
            $baseRef = '#/components/callbacks/';
        } elseif ($instance instanceof ParametersFactory) {
            $baseRef = '#/components/parameters/';
        } elseif ($instance instanceof RequestBodyFactory) {
            $baseRef = '#/components/requestBodies/';
        } elseif ($instance instanceof ResponseFactory) {
            $baseRef = '#/components/responses/';
        } elseif ($instance instanceof SchemaFactory) {
            $baseRef = '#/components/schemas/';
        } elseif ($instance instanceof SecuritySchemeFactory) {
            $baseRef = '#/components/securitySchemes/';
        }

        return Schema::ref($baseRef . $instance->build()->objectId, $objectId);
    }
}
