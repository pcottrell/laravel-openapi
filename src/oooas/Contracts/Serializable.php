<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Contracts;

interface Serializable extends \JsonSerializable
{
    public function serialize(): array;
}
