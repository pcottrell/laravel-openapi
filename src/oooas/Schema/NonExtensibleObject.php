<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema;

abstract class NonExtensibleObject extends BaseObject
{
    public function serialize(): array
    {
        if (!is_null($this->ref)) {
            return ['$ref' => $this->ref];
        }

        return $this->toArray();
    }
}
