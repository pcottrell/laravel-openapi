<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema;

use MohammadAlavi\LaravelOpenApi\Serializable;

abstract class BaseObject extends Serializable
{
    public string|null $ref = null;

    protected function __construct(
        public readonly string|null $objectId = null,
    ) {
    }

    public static function create(string|null $objectId = null): static
    {
        return new static($objectId);
    }

    // TODO: It seems not all objects need the ref method.
    //  Only objects that can be Components and reusable needs this method.
    //  Maybe this can be moved to a trait + interface.
    //  https://swagger.io/specification/#components-object
    public static function ref(string $ref, string|null $objectId = null): static
    {
        $instance = new static($objectId);

        $instance->ref = $ref;

        return $instance;
    }

    public function jsonSerialize(): array
    {
        return $this->serialize();
    }
}
