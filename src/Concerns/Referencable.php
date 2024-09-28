<?php

namespace MohammadAlavi\LaravelOpenApi\Concerns;

use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\CallbackFactory;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ParameterFactory;
use MohammadAlavi\LaravelOpenApi\Factories\Component\RequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ResponseFactory;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SchemaFactory;
use MohammadAlavi\LaravelOpenApi\Factories\Component\SecuritySchemeFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;
use MohammadAlavi\ObjectOrientedOAS\Exceptions\InvalidArgumentException;

// TODO: cleanup this.
// Is it even used? How?
// It seems there is duplicate functionality spread over some other classes like:
// MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\RequestBodyBuilder
// MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\ResponseBuilder
// MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations\CallbackBuilder
trait Referencable
{
    public static function ref(string|null $objectId = null): Schema
    {
        $clone = app(static::class);

        if (!$clone instanceof Reusable) {
            throw new InvalidArgumentException('"' . static::class . '" must implement "' . Reusable::class . '" in order to be referencable.');
        }

        $baseRef = null;

        if ($clone instanceof CallbackFactory) {
            $baseRef = '#/components/callbacks/';
        } elseif ($clone instanceof ParameterFactory) {
            $baseRef = '#/components/parameters/';
        } elseif ($clone instanceof RequestBodyFactory) {
            $baseRef = '#/components/requestBodies/';
        } elseif ($clone instanceof ResponseFactory) {
            $baseRef = '#/components/responses/';
        } elseif ($clone instanceof SchemaFactory) {
            $baseRef = '#/components/schemas/';
        } elseif ($clone instanceof SecuritySchemeFactory) {
            $baseRef = '#/components/securitySchemes/';
        }

        return Schema::ref($baseRef . $clone->build()->objectId, $objectId);
    }
}
