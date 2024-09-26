<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;

/**
 * Implementing this interface will indicate that object should be included in 'components' object.
 *
 * @see https://github.com/OAI/OpenAPI-Specification/blob/master/versions/3.0.2.md#componentsObject
 */
// TODO: How does this even work?
//  https://swagger.io/specification/#components-object
interface Reusable
{
    public static function ref(string|null $objectId = null): Schema;
}
