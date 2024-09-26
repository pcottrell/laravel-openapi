<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Contracts;

// TODO: refactor!
interface Extensible
{
    public function addExtension(string $key, mixed $value): static;
    public function __get(string $name): mixed;
}
