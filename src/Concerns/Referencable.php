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
use Webmozart\Assert\Assert;

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
        $factory = app(static::class);

        if (!$factory instanceof Reusable) {
            Assert::isInstanceOf($factory, Reusable::class);
        }

        $baseRef = null;

        if ($factory instanceof CallbackFactory) {
            $baseRef = '#/components/callbacks/';
        } elseif ($factory instanceof ParameterFactory) {
            $baseRef = '#/components/parameters/';
        } elseif ($factory instanceof RequestBodyFactory) {
            $baseRef = '#/components/requestBodies/';
        } elseif ($factory instanceof ResponseFactory) {
            $baseRef = '#/components/responses/';
        } elseif ($factory instanceof SchemaFactory) {
            $baseRef = '#/components/schemas/';
        } elseif ($factory instanceof SecuritySchemeFactory) {
            $baseRef = '#/components/securitySchemes/';
        }

        return Schema::ref($baseRef . $factory->build()->objectId, $objectId);
    }
}
