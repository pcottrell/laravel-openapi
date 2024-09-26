<?php

namespace MohammadAlavi\LaravelOpenApi;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Serializable as SerializableContract;

abstract class Serializable implements SerializableContract
{
    abstract protected function toArray(): array;
}
